<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales;
use App\Models\SaleItem;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\Product;

class SalesController extends Controller
{
    // GET /api/sales
    public function index()
    {
        return Sales::all();
    }
 
     // POST /api/sales
    public function store(Request $request)
    { 
        // $request->get('customer_id') = '1';
        // Validate the Sales data
        $salesData = $request->validate([
            'customer_id' => '',  // Total amount for the sale
            'total' => 'required|numeric|min:0',  // Total amount for the sale
            'sale_date' => 'required|date',       // Date of the sale
            'items' => 'required|array',          // Array of sale items
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.cost_price' => '',
            'items.*.mrp_price' => '',
            'items.*.discount' => '',
        ]);
        $salesData['customer_id'] = 1;
        // Start a database transaction
        $customer = Customer::find( $salesData['customer_id']);
        \DB::beginTransaction();

        try {
           
            $id=\DB::select("show table status where name='sales'; ");
            $next_sale_id=$id[0]->Auto_increment; 
            // Create the Sales record
            $sale = Sales::create([
                'customer_id' => $salesData['customer_id'],
                'customer_name' => $customer->name,
                'invoice_number' => 'INV'.sprintf('%03d',date('Y')).sprintf('%06d',$next_sale_id),
                'total' => $salesData['total'],
                'sale_date' => date('Y-m-d'),
            ]);

            // Iterate through sale items and attach to the Sale
            $saleItemsData = []; 
            foreach ($salesData['items'] as $itemData) {
                $product = Product::find($itemData['product_id']);  
                $items = new SaleItem([ 
                    'product_id'=> $itemData['product_id'],
                    'quantity'  => $itemData['quantity'],
                    'discount'  => $itemData['discount'], 
                    'cost_price'=> $product->cost_price,
                    'mrp_price' => $product->mrp_price,
                    'total'  => ($itemData['quantity'] * $product->mrp_price) - $itemData['discount']
                ]);  

                Inventory::create([
                    'product_id' => $itemData['product_id'],
                    'quantity'   => $itemData['quantity'],
                    'last_restocked' => ($product->quantity - $itemData['quantity'])
                ]);
                $saleItemsData[] = $items; 
                if ($product) {
                    $product->quantity -= $itemData['quantity'];
                    if ($product->quantity < 0) {
                        throw new \Exception("Insufficient stock for product ID: {$product->id}");
                    }
                    $product->save();
                }
            } 

            // Insert sale items into the database
            $sale->items()->saveMany($saleItemsData);

            // Commit the transaction
            \DB::commit();

            // Return response with the sale and items
            return response()->json([
                'sale' => $sale,
                'items' => $sale->items,
            ], 201);

        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            \DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
     
 
     // GET /api/sales/{id}
     public function show(Sales $sale)
     {
         return $sale;
     }
 
     // PUT /api/sales/{id}
     public function update(Request $request, Sales $sale)
     {
         $request->validate([
             'quantity' => 'integer',
             'price' => 'numeric',
             'total' => 'numeric',
             'sale_date' => 'date',
         ]);
 
         $sale->update($request->all());
         return response()->json($sale, 200);
     }
 
     // DELETE /api/sales/{id}
     public function destroy(Sales $sale)
     {
         $sale->delete();
         return response()->json(['message' => 'Sale record deleted successfully'], 200);
     }
}
