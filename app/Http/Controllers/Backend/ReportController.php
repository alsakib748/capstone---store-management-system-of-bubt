<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\DamageProduct;
use App\Models\Department;
use App\Models\Issue;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Purchase;
use App\Models\ReturnPurchase;
use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\Semester;
use App\Models\Subcategory;
use App\Models\User;
use App\Models\WareHouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function AllReport()
    {
        $purchases = Purchase::with(['purchaseItems.product', 'supplier', 'warehouse', 'user'])->get();
        return view('admin.backend.report.all_report', compact('purchases'));
    }

    public function PurchaseReport()
    {
        $purchases = Purchase::with(['purchaseItems.product', 'supplier', 'warehouse', 'semester', 'department', 'user'])->get();
        $semesters = Semester::all();
        $departments = Department::all();
        $subcategories = Subcategory::all();
        $products = Product::all();
        return view('admin.backend.report.purchase_report', compact('purchases', 'semesters', 'departments', 'subcategories', 'products'));
    }

    public function DamageProductReport()
    {
        $damageProducts = DamageProduct::with(['damageProductItem.product', 'semester'])->get();

        // Get latest purchase price for each product
        $purchasePrices = DB::table('purchase_items')
            ->select('product_id', DB::raw('MAX(id) as max_id'))
            ->groupBy('product_id');

        $latestPrices = DB::table('purchase_items as pi')
            ->joinSub($purchasePrices, 'latest', function ($join) {
                $join->on('pi.id', '=', 'latest.max_id');
            })
            ->select('pi.product_id', 'pi.net_unit_cost')
            ->get()
            ->keyBy('product_id');

        $semesters = Semester::all();
        $products = Product::all();
        return view('admin.backend.report.damage_product_report', compact('damageProducts', 'semesters', 'products', 'latestPrices'));
    }


    public function IssueReport()
    {
        $issues = Issue::with(['issueItems.product', 'semester', 'department', 'user.department', 'issuedByUser'])->get();

        // Get latest purchase price for each product
        $purchasePrices = DB::table('purchase_items')
            ->select('product_id', DB::raw('MAX(id) as max_id'))
            ->groupBy('product_id');

        $latestPrices = DB::table('purchase_items as pi')
            ->joinSub($purchasePrices, 'latest', function ($join) {
                $join->on('pi.id', '=', 'latest.max_id');
            })
            ->select('pi.product_id', 'pi.net_unit_cost')
            ->get()
            ->keyBy('product_id');

        $semesters = Semester::all();
        $departments = Department::all();
        $products = Product::all();
        $users = User::all();
        return view('admin.backend.report.issue_report', compact('issues', 'semesters', 'departments', 'products', 'users', 'latestPrices'));
    }


    public function StockReport()
    {
        $subcategories = Subcategory::all();
        $products = Product::with(['category', 'subcategory', 'brand'])->get();
        $brands = \App\Models\Brand::all();

        // Get latest purchase price for each product from purchase_items table
        $latestPrices = DB::table('purchase_items')
            ->select('product_id', DB::raw('MAX(id) as max_id'))
            ->groupBy('product_id');

        $prices = DB::table('purchase_items as pi')
            ->joinSub($latestPrices, 'latest', function ($join) {
                $join->on('pi.id', '=', 'latest.max_id');
            })
            ->select('pi.product_id', 'pi.net_unit_cost')
            ->get()
            ->keyBy('product_id');

        return view('admin.backend.report.stock_wise_report', compact('subcategories', 'products', 'brands', 'prices'));
    }


    public function FixedAssetReport()
    {
        $subcategories = Subcategory::whereHas('products', function ($query) {
            $query->where('fixed_asset', 1);
        })->get();

        $brands = Brand::whereHas('products', function ($query) {
            $query->where('fixed_asset', 1);
        })->get();

        $products = Product::where('fixed_asset', 1)->get();

        // Get fixed asset purchases with items and calculate depreciation
        $purchases = Purchase::with(['purchaseItems.product.category', 'purchaseItems.product.subcategory', 'purchaseItems.product.brand'])
            ->whereHas('purchaseItems.product', function ($query) {
                $query->where('fixed_asset', 1);
            })
            ->get();

        // Calculate current price and depreciation for each purchase item
        $purchaseData = $this->calculateDepreciation($purchases);

        return view('admin.backend.report.fixed_asset_report', compact('subcategories', 'brands', 'products', 'purchaseData'));
    }

    private function calculateDepreciation($purchases)
    {
        $data = [];
        $today = Carbon::now()->startOfDay();

        foreach ($purchases as $purchase) {
            foreach ($purchase->purchaseItems as $item) {
                $product = $item->product;
                if (!$product || $product->fixed_asset != 1) {
                    continue;
                }

                $originalPrice = floatval($item->net_unit_cost);
                $purchaseDate = Carbon::parse($purchase->date)->startOfDay();
                $expiryDate = $item->expiry_date ? Carbon::parse($item->expiry_date)->startOfDay() : null;

                $currentPrice = $originalPrice;
                $depreciation = 0;
                $remainingDays = 0;
                $totalDays = 0;

                if ($expiryDate && $expiryDate > $today) {
                    $remainingDays = $today->diffInDays($expiryDate, false);
                    $totalDays = $purchaseDate->diffInDays($expiryDate, false);

                    if ($totalDays > 0) {
                        $expiryRatio = $remainingDays / $totalDays;
                        $currentPrice = $originalPrice * $expiryRatio;
                        $depreciation = $originalPrice - $currentPrice;
                    }
                } elseif ($expiryDate && $expiryDate <= $today) {
                    // Expired - price becomes 0
                    $currentPrice = 0;
                    $depreciation = $originalPrice;
                    $remainingDays = 0;
                }

                $data[] = [
                    'purchase_id' => $purchase->id,
                    'purchase_date' => $purchase->date,
                    'tracking_no' => $purchase->tracking_no,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'category' => $product->category->category_name ?? '-',
                    'subcategory' => $product->subcategory->subcategory_name ?? '-',
                    'brand' => $product->brand->name ?? '-',
                    'quantity' => $item->quantity,
                    'original_price' => $originalPrice,
                    'current_price' => $currentPrice,
                    'depreciation' => $depreciation,
                    'remaining_days' => $remainingDays,
                    'expiry_date' => $item->expiry_date,
                    'stock_value' => $currentPrice * $item->quantity,
                    'total_value' => $originalPrice * $item->quantity,
                ];
            }
        }

        return collect($data);
    }

    public function FilterFixedAsset(Request $request)
    {
        $subcategoryId = $request->input('subcategory_id');
        $brandId = $request->input('brand_id');
        $productId = $request->input('product_id');
        $sortBy = $request->input('sort_by');

        $query = Purchase::with(['purchaseItems.product.category', 'purchaseItems.product.subcategory', 'purchaseItems.product.brand'])
            ->whereHas('purchaseItems.product', function ($query) use ($subcategoryId, $brandId, $productId) {
                $query->where('fixed_asset', 1);
                if ($productId) {
                    $query->where('id', $productId);
                }
                if ($subcategoryId) {
                    $query->where('subcategory_id', $subcategoryId);
                }
                if ($brandId) {
                    $query->where('brand_id', $brandId);
                }
            });

        // Apply sorting
        switch ($sortBy) {
            case 'latest':
                $query->latest('date');
                break;
            case 'oldest':
                $query->oldest('date');
                break;
            case 'name_asc':
                $query->orderBy('tracking_no', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('tracking_no', 'desc');
                break;
            case 'qty_asc':
            case 'qty_desc':
                // Need to handle this differently for purchase items
                break;
            default:
                $query->latest('date');
        }

        $purchases = $query->get();
        $purchaseData = $this->calculateDepreciation($purchases);

        // Sort by quantity if needed
        if ($sortBy === 'qty_asc') {
            $purchaseData = $purchaseData->sortBy('quantity')->values();
        } elseif ($sortBy === 'qty_desc') {
            $purchaseData = $purchaseData->sortByDesc('quantity')->values();
        }

        return response()->json(['purchaseData' => $purchaseData]);
    }


    public function FilterStock(Request $request)
    {
        $subcategoryId = $request->input('subcategory_id');
        $brandId = $request->input('brand_id');
        $productId = $request->input('product_id');
        $stockType = $request->input('stock_type');

        $query = Product::with(['category', 'subcategory', 'brand']);

        if ($productId) {
            $query->where('id', $productId);
        }

        if ($subcategoryId) {
            $query->where('subcategory_id', $subcategoryId);
        }

        if ($brandId) {
            $query->where('brand_id', $brandId);
        }

        $products = $query->get();

        // Filter by stock type
        $filteredProducts = $products->filter(function ($product) use ($stockType) {
            $stock = $product->product_qty ?? 0;
            $alert = $product->stock_alert ?? 10;

            switch ($stockType) {
                case 'low_stock':
                    return $stock > 0 && $stock <= $alert;
                case 'out_stock':
                    return $stock == 0;
                case 'available':
                    return $stock > $alert;
                default:
                    return true; // All stock
            }
        })->values();

        // Get latest purchase price for each product from purchase_items table
        $latestPrices = DB::table('purchase_items')
            ->select('product_id', DB::raw('MAX(id) as max_id'))
            ->groupBy('product_id');

        $prices = DB::table('purchase_items as pi')
            ->joinSub($latestPrices, 'latest', function ($join) {
                $join->on('pi.id', '=', 'latest.max_id');
            })
            ->select('pi.product_id', 'pi.net_unit_cost')
            ->get()
            ->keyBy('product_id');

        return response()->json(['products' => $filteredProducts, 'prices' => $prices]);
    }

    public function FilterIssues(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $semesterId = $request->input('semester_id');
        $departmentId = $request->input('department_id');
        $userId = $request->input('user_id');
        $issuedBy = $request->input('issued_by');
        $productId = $request->input('product_id');

        $query = Issue::with(['issueItems.product', 'semester', 'department', 'user.department', 'issuedByUser']);

        if ($fromDate && $toDate) {
            $startDate = Carbon::parse($fromDate)->startOfDay();
            $endDate = Carbon::parse($toDate)->endOfDay();
            $query->whereBetween('date', [$startDate, $endDate]);
        } elseif ($fromDate) {
            $query->whereDate('date', '>=', Carbon::parse($fromDate)->toDateString());
        } elseif ($toDate) {
            $query->whereDate('date', '<=', Carbon::parse($toDate)->toDateString());
        }

        if ($semesterId) {
            $query->where('semester_id', $semesterId);
        }

        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        if ($userId) {
            $query->where('user_id', $userId);
        }

        if ($issuedBy) {
            $query->where('issued_by', $issuedBy);
        }

        if ($productId) {
            $query->whereHas('issueItems', function ($itemQuery) use ($productId) {
                $itemQuery->where('product_id', $productId);
            });
        }

        $issues = $query->latest('date')->get();

        // Get latest purchase price for each product
        $purchasePrices = DB::table('purchase_items')
            ->select('product_id', DB::raw('MAX(id) as max_id'))
            ->groupBy('product_id');

        $latestPrices = DB::table('purchase_items as pi')
            ->joinSub($purchasePrices, 'latest', function ($join) {
                $join->on('pi.id', '=', 'latest.max_id');
            })
            ->select('pi.product_id', 'pi.net_unit_cost')
            ->get()
            ->keyBy('product_id');

        return response()->json(['issues' => $issues, 'latestPrices' => $latestPrices]);
    }


    public function FilterDamageProducts(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $semesterId = $request->input('semester_id');
        $productId = $request->input('product_id');

        $query = DamageProduct::with(['damageProductItem.product', 'semester']);

        if ($fromDate && $toDate) {
            $startDate = Carbon::parse($fromDate)->startOfDay();
            $endDate = Carbon::parse($toDate)->endOfDay();
            $query->whereBetween('date', [$startDate, $endDate]);
        } elseif ($fromDate) {
            $query->whereDate('date', '>=', Carbon::parse($fromDate)->toDateString());
        } elseif ($toDate) {
            $query->whereDate('date', '<=', Carbon::parse($toDate)->toDateString());
        }

        if ($semesterId) {
            $query->where('semester_id', $semesterId);
        }

        if ($productId) {
            $query->whereHas('damageProductItem', function ($itemQuery) use ($productId) {
                $itemQuery->where('product_id', $productId);
            });
        }

        $damageProducts = $query->latest('date')->get();

        // Get latest purchase price for each product
        $purchasePrices = DB::table('purchase_items')
            ->select('product_id', DB::raw('MAX(id) as max_id'))
            ->groupBy('product_id');

        $latestPrices = DB::table('purchase_items as pi')
            ->joinSub($purchasePrices, 'latest', function ($join) {
                $join->on('pi.id', '=', 'latest.max_id');
            })
            ->select('pi.product_id', 'pi.net_unit_cost')
            ->get()
            ->keyBy('product_id');

        return response()->json(['damageProducts' => $damageProducts, 'purchasePrices' => $latestPrices]);
    }
    // End Method

    public function FilterPurchases(Request $request)
    {
        $fromDate = $request->input('from_date', $request->input('start_date'));
        $toDate = $request->input('to_date', $request->input('end_date'));
        $semesterId = $request->input('semester_id');
        $departmentId = $request->input('department_id');
        $userId = $request->input('user_id');
        $subcategoryId = $request->input('subcategory_id');
        $productId = $request->input('product_id');

        $query = Purchase::with(['purchaseItems.product', 'supplier', 'warehouse', 'semester', 'department', 'user']);

        if ($fromDate && $toDate) {
            $startDate = Carbon::parse($fromDate)->startOfDay();
            $endDate = Carbon::parse($toDate)->endOfDay();
            $query->whereBetween('date', [$startDate, $endDate]);
        } elseif ($fromDate) {
            $query->whereDate('date', '>=', Carbon::parse($fromDate)->toDateString());
        } elseif ($toDate) {
            $query->whereDate('date', '<=', Carbon::parse($toDate)->toDateString());
        }

        if ($semesterId) {
            $query->where('semester_id', $semesterId);
        }

        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        if ($userId) {
            $query->where('user_id', $userId);
        }

        if ($productId) {
            $query->whereHas('purchaseItems', function ($itemQuery) use ($productId) {
                $itemQuery->where('product_id', $productId);
            });
        }

        if ($subcategoryId) {
            $query->whereHas('purchaseItems.product', function ($productQuery) use ($subcategoryId) {
                $productQuery->where('subcategory_id', $subcategoryId);
            });
        }

        $purchases = $query->latest('date')->get();
        return response()->json(['purchases' => $purchases]);

    }
    // End Method

    public function PurchaseReturnReport()
    {
        $returnPurchases = ReturnPurchase::with(['purchaseItems.product', 'supplier', 'warehouse'])->get();
        return view('admin.backend.report.purchase_return_report', compact('returnPurchases'));
    }
    // End Method


    public function SaleReport()
    {
        $saleReports = Sale::with(['saleItems.product', 'customer', 'warehouse'])->get();
        return view('admin.backend.report.sale_report', compact('saleReports'));
    }
    // End Method

    public function FilterSales(Request $request)
    {

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $query = Sale::with(['saleItems.product', 'customer', 'warehouse']);

        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        $sales = $query->get();
        return response()->json(['sales' => $sales]);

    }
    // End Method

    public function SaleReturnReport()
    {
        $returnSales = SaleReturn::with(['saleReturnItems.product', 'customer', 'warehouse'])->get();
        return view('admin.backend.report.sales_return_report', compact('returnSales'));
    }
    // End Method

    public function ProductStockReport()
    {
        $products = Product::with(['category', 'warehouse'])->get();
        return view('admin.backend.report.stock_report', compact('products'));

    }
    // End Method


}