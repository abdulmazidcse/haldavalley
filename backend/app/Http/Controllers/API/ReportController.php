<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use App\Models\Sales;
use App\Models\SaleItem;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\Product;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function productWiseSales(Request $request)
    {
        // Validate date range input
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // Query to get product-wise sales within the date range
        $report = SaleItem::with('product')
            ->selectRaw('product_id, SUM(quantity) as total_quantity, SUM(total) as total_sales')
            // ->whereBetween('created_at', [$startDate, $endDate])
            ->whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59'])
            ->groupBy('product_id')
            ->get();

        return response()->json($report);

        ProductResource::collection(Product::all());
    }

    public function dateWiseSales(Request $request)
    {
        // Validate date range input
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        // Query to get date-wise sales within the date range
        $report = Sales::selectRaw('DATE(sale_date) as sale_date, SUM(total) as total_sales')
            ->whereBetween('sale_date', [$startDate, $endDate])
            ->groupByRaw('DATE(sale_date)')
            ->get();

        return response()->json($report);
    }

    public function productWiseStock()
    {
        // Query to get product-wise available stock
        $report = Product::select('id', 'name', 'quantity')
            ->where('quantity', '>', 0) // Only products with stock available
            ->get();

        return response()->json($report);
    }
}
