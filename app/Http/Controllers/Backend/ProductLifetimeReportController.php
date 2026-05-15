<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\Reports\ProductLifetimeReportService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProductLifetimeReportController extends Controller
{
    protected $reportService;

    public function __construct(ProductLifetimeReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Display the report index page with filters
     */
    public function index()
    {
        $products = $this->reportService->getAllProducts();
        $semesters = $this->reportService->getAllSemesters();

        return view('admin.backend.report.product_lifetime_report', compact('products', 'semesters'));
    }

    /**
     * Generate the report with filters
     */
    public function generate(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date',
            'semester_id' => 'nullable|integer|exists:semesters,id',
        ]);

        $fromDate = $request->input('from_date') ?: date('Y-m-01'); // Default to first day of month
        $toDate = $request->input('to_date') ?: date('Y-m-d'); // Default to today
        $productId = $request->input('product_id');
        $semesterId = $request->input('semester_id');

        $reportData = $this->reportService->generateFinalReport($productId, $fromDate, $toDate, $semesterId);

        if (!$reportData) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        $products = $this->reportService->getAllProducts();
        $semesters = $this->reportService->getAllSemesters();

        return view('admin.backend.report.product_lifetime_report', compact('products', 'semesters', 'reportData'));
    }

    /**
     * AJAX filter - generate report
     */
    public function ajaxGenerate(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|integer|exists:products,id',
                'from_date' => 'nullable|date',
                'to_date' => 'nullable|date',
                'semester_id' => 'nullable|integer|exists:semesters,id',
            ]);

            $fromDate = $request->input('from_date') ?: null;
            $toDate = $request->input('to_date') ?: date('Y-m-d');
            $productId = $request->input('product_id');
            $semesterId = $request->input('semester_id') ?: null;

            $reportData = $this->reportService->generateFinalReport($productId, $fromDate, $toDate, $semesterId);

            if (!$reportData) {
                return response()->json(['error' => 'Product not found.'], 404);
            }

            // Get detailed history
            $purchaseHistory = $this->reportService->getProductPurchaseHistory($productId, $fromDate, $toDate, $semesterId);
            $issueHistory = $this->reportService->getProductIssueHistory($productId, $fromDate, $toDate, $semesterId);
            $damageHistory = $this->reportService->getProductDamageHistory($productId, $fromDate, $toDate, $semesterId);
            $returnHistory = $this->reportService->getProductReturnHistory($productId, $fromDate, $toDate, $semesterId);

            return response()->json([
                'report' => $reportData,
                'purchase_history' => $purchaseHistory,
                'issue_history' => $issueHistory,
                'damage_history' => $damageHistory,
                'return_history' => $returnHistory,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Export report to PDF (placeholder - requires dompdf or similar)
     */
    public function exportPdf(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'product_id' => 'required|integer|exists:products,id',
            'semester_id' => 'nullable|integer|exists:semesters,id',
        ]);

        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $productId = $request->input('product_id');
        $semesterId = $request->input('semester_id');

        $reportData = $this->reportService->generateFinalReport($productId, $fromDate, $toDate, $semesterId);

        // For now, redirect back with the data
        // PDF export would require installing dompdf and rendering view to PDF
        return redirect()->route('product.lifetime.report')->with('reportData', $reportData);
    }
}