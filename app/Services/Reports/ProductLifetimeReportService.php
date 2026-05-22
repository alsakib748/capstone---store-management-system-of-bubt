<?php

namespace App\Services\Reports;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Issue;
use App\Models\IssueItem;
use App\Models\DamageProduct;
use App\Models\DamageProductItem;
use App\Models\IssueReturn;
use App\Models\IssueReturnItem;
use App\Models\Product;
use App\Models\Semester;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductLifetimeReportService
{
    /**
     * Calculate opening stock for a product before the given date
     * Opening Stock = Previous Purchases - Previous Issues - Previous Damages + Previous Returns
     * If semester is selected, opening uses previous semester's data
     */
    public function calculateOpeningStock($productId, $fromDate, $semesterId = null)
    {
        // If no from_date and no semester, opening stock is 0
        if (!$fromDate && !$semesterId) {
            return [
                'previous_purchase' => 0,
                'previous_issue' => 0,
                'previous_damage' => 0,
                'previous_return' => 0,
                'opening_stock' => 0,
            ];
        }

        // If semester is selected, use previous semester for opening calculation
        $previousSemesterId = null;
        $useSemesterOpening = false;

        if ($semesterId) {
            $currentSemester = Semester::find($semesterId);
            if ($currentSemester) {
                // Find previous semester by code (e.g., 002 -> 001)
                $currentCode = (int) $currentSemester->code;
                if ($currentCode > 1) {
                    $previousCode = str_pad($currentCode - 1, 3, '0', STR_PAD_LEFT);
                    $previousSemester = Semester::where('code', $previousCode)->first();
                    if ($previousSemester) {
                        $previousSemesterId = $previousSemester->id;
                        $useSemesterOpening = true;
                    }
                }
            }
        }

        // If using semester opening, calculate from previous semester only
        if ($useSemesterOpening) {
            $previousPurchaseQty = DB::table('purchase_items')
                ->join('purchases', 'purchase_items.purchase_id', '=', 'purchases.id')
                ->where('purchase_items.product_id', $productId)
                ->where('purchases.semester_id', $previousSemesterId)
                ->sum('purchase_items.quantity') ?? 0;

            $previousIssueQty = DB::table('issue_items')
                ->join('issues', 'issue_items.issue_id', '=', 'issues.id')
                ->where('issue_items.product_id', $productId)
                ->where('issues.semester_id', $previousSemesterId)
                ->sum('issue_items.qty') ?? 0;

            $previousDamageQty = DB::table('damage_product_items')
                ->join('damage_products', 'damage_product_items.damage_product_id', '=', 'damage_products.id')
                ->where('damage_product_items.product_id', $productId)
                ->where('damage_products.semester_id', $previousSemesterId)
                ->sum('damage_product_items.qty') ?? 0;

            $previousReturnQty = DB::table('issue_return_items')
                ->join('issue_returns', 'issue_return_items.issue_return_id', '=', 'issue_returns.id')
                ->where('issue_return_items.product_id', $productId)
                ->where('issue_returns.semester_id', $previousSemesterId)
                ->sum('issue_return_items.qty') ?? 0;

            return [
                'previous_purchase' => (float) $previousPurchaseQty,
                'previous_issue' => (float) $previousIssueQty,
                'previous_damage' => (float) $previousDamageQty,
                'previous_return' => (float) $previousReturnQty,
                'opening_stock' => (float) ($previousPurchaseQty - $previousIssueQty - $previousDamageQty + $previousReturnQty),
                'previous_semester_id' => $previousSemesterId,
            ];
        }

        // Default date-based calculation
        $fromDateStr = Carbon::parse($fromDate)->toDateString();

        // Previous Purchases - use join instead of whereHas for reliability
        $previousPurchaseQty = DB::table('purchase_items')
            ->join('purchases', 'purchase_items.purchase_id', '=', 'purchases.id')
            ->where('purchase_items.product_id', $productId)
            ->whereDate('purchases.date', '<', $fromDateStr)
            ->when($semesterId, function ($query) use ($semesterId) {
                return $query->where('purchases.semester_id', $semesterId);
            })
            ->sum('purchase_items.quantity') ?? 0;

        // Previous Issues
        $previousIssueQty = DB::table('issue_items')
            ->join('issues', 'issue_items.issue_id', '=', 'issues.id')
            ->where('issue_items.product_id', $productId)
            ->whereDate('issues.date', '<', $fromDateStr)
            ->when($semesterId, function ($query) use ($semesterId) {
                return $query->where('issues.semester_id', $semesterId);
            })
            ->sum('issue_items.qty') ?? 0;

        // Previous Damages
        $previousDamageQty = DB::table('damage_product_items')
            ->join('damage_products', 'damage_product_items.damage_product_id', '=', 'damage_products.id')
            ->where('damage_product_items.product_id', $productId)
            ->whereDate('damage_products.date', '<', $fromDateStr)
            ->when($semesterId, function ($query) use ($semesterId) {
                return $query->where('damage_products.semester_id', $semesterId);
            })
            ->sum('damage_product_items.qty') ?? 0;

        // Previous Returns
        $previousReturnQty = DB::table('issue_return_items')
            ->join('issue_returns', 'issue_return_items.issue_return_id', '=', 'issue_returns.id')
            ->where('issue_return_items.product_id', $productId)
            ->whereDate('issue_returns.return_date', '<', $fromDateStr)
            ->when($semesterId, function ($query) use ($semesterId) {
                return $query->where('issue_returns.semester_id', $semesterId);
            })
            ->sum('issue_return_items.qty') ?? 0;

        return [
            'previous_purchase' => (float) $previousPurchaseQty,
            'previous_issue' => (float) $previousIssueQty,
            'previous_damage' => (float) $previousDamageQty,
            'previous_return' => (float) $previousReturnQty,
            'opening_stock' => (float) ($previousPurchaseQty - $previousIssueQty - $previousDamageQty + $previousReturnQty),
        ];
    }

    /**
     * Calculate purchase summary for the given period
     */
    public function calculatePurchaseSummary($productId, $fromDate, $toDate, $semesterId = null)
    {
        $query = DB::table('purchase_items')
            ->join('purchases', 'purchase_items.purchase_id', '=', 'purchases.id')
            ->where('purchase_items.product_id', $productId);

        if ($fromDate && $toDate) {
            $query->whereBetween('purchases.date', [
                Carbon::parse($fromDate)->toDateString(),
                Carbon::parse($toDate)->toDateString()
            ]);
        } elseif ($fromDate) {
            $query->whereDate('purchases.date', '>=', Carbon::parse($fromDate)->toDateString());
        } elseif ($toDate) {
            $query->whereDate('purchases.date', '<=', Carbon::parse($toDate)->toDateString());
        }

        if ($semesterId) {
            $query->where('purchases.semester_id', $semesterId);
        }

        $totalQty = $query->sum('purchase_items.quantity') ?? 0;
        $totalValue = $query->sum(DB::raw('purchase_items.net_unit_cost * purchase_items.quantity')) ?? 0;
        $avgPrice = $totalQty > 0 ? ($totalValue / $totalQty) : 0;

        return [
            'total_qty' => (float) $totalQty,
            'total_value' => (float) $totalValue,
            'avg_price' => (float) $avgPrice,
        ];
    }

    /**
     * Calculate issue summary for the given period
     */
    public function calculateIssueSummary($productId, $fromDate, $toDate, $semesterId = null)
    {
        $query = DB::table('issue_items')
            ->join('issues', 'issue_items.issue_id', '=', 'issues.id')
            ->where('issue_items.product_id', $productId);

        if ($fromDate && $toDate) {
            $query->whereBetween('issues.date', [
                Carbon::parse($fromDate)->toDateString(),
                Carbon::parse($toDate)->toDateString()
            ]);
        } elseif ($fromDate) {
            $query->whereDate('issues.date', '>=', Carbon::parse($fromDate)->toDateString());
        } elseif ($toDate) {
            $query->whereDate('issues.date', '<=', Carbon::parse($toDate)->toDateString());
        }

        if ($semesterId) {
            $query->where('issues.semester_id', $semesterId);
        }

        $totalQty = $query->sum('issue_items.qty') ?? 0;

        return [
            'total_qty' => (float) $totalQty,
        ];
    }

    /**
     * Calculate damage summary for the given period
     */
    public function calculateDamageSummary($productId, $fromDate, $toDate, $semesterId = null, $avgPurchasePrice = 0)
    {
        $query = DB::table('damage_product_items')
            ->join('damage_products', 'damage_product_items.damage_product_id', '=', 'damage_products.id')
            ->where('damage_product_items.product_id', $productId);

        if ($fromDate && $toDate) {
            $query->whereBetween('damage_products.date', [
                Carbon::parse($fromDate)->toDateString(),
                Carbon::parse($toDate)->toDateString()
            ]);
        } elseif ($fromDate) {
            $query->whereDate('damage_products.date', '>=', Carbon::parse($fromDate)->toDateString());
        } elseif ($toDate) {
            $query->whereDate('damage_products.date', '<=', Carbon::parse($toDate)->toDateString());
        }

        if ($semesterId) {
            $query->where('damage_products.semester_id', $semesterId);
        }

        $totalQty = $query->sum('damage_product_items.qty') ?? 0;
        $damageValue = $totalQty * $avgPurchasePrice;

        return [
            'total_qty' => (float) $totalQty,
            'damage_value' => (float) $damageValue,
        ];
    }

    /**
     * Calculate return summary for the given period
     */
    public function calculateReturnSummary($productId, $fromDate, $toDate, $semesterId = null)
    {
        $query = DB::table('issue_return_items')
            ->join('issue_returns', 'issue_return_items.issue_return_id', '=', 'issue_returns.id')
            ->where('issue_return_items.product_id', $productId);

        if ($fromDate && $toDate) {
            $query->whereBetween('issue_returns.return_date', [
                Carbon::parse($fromDate)->toDateString(),
                Carbon::parse($toDate)->toDateString()
            ]);
        } elseif ($fromDate) {
            $query->whereDate('issue_returns.return_date', '>=', Carbon::parse($fromDate)->toDateString());
        } elseif ($toDate) {
            $query->whereDate('issue_returns.return_date', '<=', Carbon::parse($toDate)->toDateString());
        }

        if ($semesterId) {
            $query->where('issue_returns.semester_id', $semesterId);
        }

        $totalQty = $query->sum('issue_return_items.qty') ?? 0;

        return [
            'total_qty' => (float) $totalQty,
        ];
    }

    /**
     * Calculate closing summary
     */
    public function calculateClosingSummary($openingStock, $purchaseQty, $issueQty, $damageQty, $returnQty, $avgPrice)
    {
        $closingStock = $openingStock + $purchaseQty - $issueQty - $damageQty + $returnQty;
        $stockValue = $closingStock * $avgPrice;

        return [
            'opening_stock' => (float) $openingStock,
            'purchase_qty' => (float) $purchaseQty,
            'issue_qty' => (float) $issueQty,
            'damage_qty' => (float) $damageQty,
            'return_qty' => (float) $returnQty,
            'closing_stock' => (float) $closingStock,
            'avg_price' => (float) $avgPrice,
            'stock_value' => (float) $stockValue,
        ];
    }

    /**
     * Generate the final report with all calculations
     */
    public function generateFinalReport($productId, $fromDate, $toDate, $semesterId = null)
    {
        $product = Product::with(['category', 'subcategory', 'brand'])->find($productId);

        if (!$product) {
            return null;
        }

        // Keep dates as null if not provided - no default dates
        $effectiveFromDate = $fromDate;
        $effectiveToDate = $toDate;

        // Calculate Opening Stock (before from_date or before semester)
        $openingData = $this->calculateOpeningStock($productId, $effectiveFromDate, $semesterId);

        // Calculate Purchase Summary (from_date to to_date)
        $purchaseSummary = $this->calculatePurchaseSummary($productId, $effectiveFromDate, $effectiveToDate, $semesterId);

        // Calculate Issue Summary (from_date to to_date)
        $issueSummary = $this->calculateIssueSummary($productId, $effectiveFromDate, $effectiveToDate, $semesterId);

        // Calculate Damage Summary (from_date to to_date)
        $damageSummary = $this->calculateDamageSummary($productId, $effectiveFromDate, $effectiveToDate, $semesterId, $purchaseSummary['avg_price']);

        // Calculate Return Summary (from_date to to_date)
        $returnSummary = $this->calculateReturnSummary($productId, $effectiveFromDate, $effectiveToDate, $semesterId);

        // Calculate Closing Summary
        $closingSummary = $this->calculateClosingSummary(
            $openingData['opening_stock'],
            $purchaseSummary['total_qty'],
            $issueSummary['total_qty'],
            $damageSummary['total_qty'],
            $returnSummary['total_qty'],
            $purchaseSummary['avg_price']
        );

        return [
            'product' => $product,
            'opening' => $openingData,
            'purchase' => $purchaseSummary,
            'issue' => $issueSummary,
            'damage' => $damageSummary,
            'return' => $returnSummary,
            'closing' => $closingSummary,
            'filters' => [
                'from_date' => $effectiveFromDate,
                'to_date' => $effectiveToDate,
                'semester_id' => $semesterId,
                'product_id' => $productId,
            ],
        ];
    }

    /**
     * Get all products for filter dropdown
     */
    public function getAllProducts()
    {
        return Product::orderBy('name')->get();
    }

    /**
     * Get all semesters for filter dropdown
     */
    public function getAllSemesters()
    {
        return Semester::orderBy('code')->orderBy('name')->get();
    }

    /**
     * Get product purchase history for details
     */
    public function getProductPurchaseHistory($productId, $fromDate, $toDate, $semesterId = null)
    {
        $query = PurchaseItem::where('product_id', $productId)
            ->with(['purchase.supplier', 'purchase.semester']);

        if ($semesterId) {
            $query->whereHas('purchase', function ($q) use ($semesterId) {
                $q->where('semester_id', $semesterId);
            });
        } elseif ($fromDate && $toDate) {
            $query->whereHas('purchase', function ($q) use ($fromDate, $toDate) {
                $q->whereBetween('date', [
                    Carbon::parse($fromDate)->toDateString(),
                    Carbon::parse($toDate)->toDateString()
                ]);
            });
        } elseif ($fromDate) {
            $query->whereHas('purchase', function ($q) use ($fromDate) {
                $q->whereDate('date', '>=', Carbon::parse($fromDate)->toDateString());
            });
        } elseif ($toDate) {
            $query->whereHas('purchase', function ($q) use ($toDate) {
                $q->whereDate('date', '<=', Carbon::parse($toDate)->toDateString());
            });
        }

        return $query->get();
    }

    /**
     * Get product issue history for details
     */
    public function getProductIssueHistory($productId, $fromDate, $toDate, $semesterId = null)
    {
        $query = IssueItem::where('product_id', $productId)
            ->with(['issue.department', 'issue.user', 'issue.semester']);

        if ($semesterId) {
            $query->whereHas('issue', function ($q) use ($semesterId) {
                $q->where('semester_id', $semesterId);
            });
        } elseif ($fromDate && $toDate) {
            $query->whereHas('issue', function ($q) use ($fromDate, $toDate) {
                $q->whereBetween('date', [
                    Carbon::parse($fromDate)->toDateString(),
                    Carbon::parse($toDate)->toDateString()
                ]);
            });
        } elseif ($fromDate) {
            $query->whereHas('issue', function ($q) use ($fromDate) {
                $q->whereDate('date', '>=', Carbon::parse($fromDate)->toDateString());
            });
        } elseif ($toDate) {
            $query->whereHas('issue', function ($q) use ($toDate) {
                $q->whereDate('date', '<=', Carbon::parse($toDate)->toDateString());
            });
        }

        return $query->get();
    }

    /**
     * Get product damage history for details
     */
    public function getProductDamageHistory($productId, $fromDate, $toDate, $semesterId = null)
    {
        $query = DamageProductItem::where('product_id', $productId)
            ->with(['damageProduct.semester']);

        if ($semesterId) {
            $query->whereHas('damageProduct', function ($q) use ($semesterId) {
                $q->where('semester_id', $semesterId);
            });
        } elseif ($fromDate && $toDate) {
            $query->whereHas('damageProduct', function ($q) use ($fromDate, $toDate) {
                $q->whereBetween('date', [
                    Carbon::parse($fromDate)->toDateString(),
                    Carbon::parse($toDate)->toDateString()
                ]);
            });
        } elseif ($fromDate) {
            $query->whereHas('damageProduct', function ($q) use ($fromDate) {
                $q->whereDate('date', '>=', Carbon::parse($fromDate)->toDateString());
            });
        } elseif ($toDate) {
            $query->whereHas('damageProduct', function ($q) use ($toDate) {
                $q->whereDate('date', '<=', Carbon::parse($toDate)->toDateString());
            });
        }

        return $query->get();
    }

    /**
     * Get product return history for details
     */
    public function getProductReturnHistory($productId, $fromDate, $toDate, $semesterId = null)
    {
        $query = IssueReturnItem::where('product_id', $productId)
            ->with(['issueReturn.issue', 'issueReturn.user', 'issueReturn.semester']);

        if ($semesterId) {
            $query->whereHas('issueReturn', function ($q) use ($semesterId) {
                $q->where('semester_id', $semesterId);
            });
        } elseif ($fromDate && $toDate) {
            $query->whereHas('issueReturn', function ($q) use ($fromDate, $toDate) {
                $q->whereBetween('return_date', [
                    Carbon::parse($fromDate)->toDateString(),
                    Carbon::parse($toDate)->toDateString()
                ]);
            });
        } elseif ($fromDate) {
            $query->whereHas('issueReturn', function ($q) use ($fromDate) {
                $q->whereDate('return_date', '>=', Carbon::parse($fromDate)->toDateString());
            });
        } elseif ($toDate) {
            $query->whereHas('issueReturn', function ($q) use ($toDate) {
                $q->whereDate('return_date', '<=', Carbon::parse($toDate)->toDateString());
            });
        }

        return $query->get();
    }
}
