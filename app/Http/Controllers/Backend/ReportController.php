<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Purchase;
use App\Models\Subcategory;
use App\Models\ReturnPurchase;
use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\Semester;
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