<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;

class InventoryController extends Controller
{
    // GET /api/inventory
    public function index()
    {
        return Inventory::all();
    }

    // POST /api/inventory
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
            'last_restocked' => 'nullable|date',
        ]);

        $inventory = Inventory::create($request->all());
        return response()->json($inventory, 201);
    }

    // GET /api/inventory/{id}
    public function show(Inventory $inventory)
    {
        return $inventory;
    }

    // PUT /api/inventory/{id}
    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'quantity' => 'integer',
            'last_restocked' => 'date',
        ]);

        $inventory->update($request->all());
        return response()->json($inventory, 200);
    }

    // DELETE /api/inventory/{id}
    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return response()->json(['message' => 'Inventory record deleted successfully'], 200);
    }
}
