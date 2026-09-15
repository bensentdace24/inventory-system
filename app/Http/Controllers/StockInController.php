<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\StockIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockInController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inventory_item_id' => 'required|exists:inventory_items,id',
            'quantity' => 'required|integer|min:1',
            'stock_in_date' => 'required|date',
            'remarks' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($validated) {

            $item = InventoryItem::lockForUpdate()
                ->findOrFail($validated['inventory_item_id']);

            // Add the incoming quantity to total and remaining stock.
            $item->quantity += $validated['quantity'];
            $item->remaining_quantity += $validated['quantity'];

            $item->save();

            $stockIn = StockIn::create($validated);

            return response()->json([
                'message' => 'Stock added successfully.',
                'item' => $item,
                'stock_in' => $stockIn,
            ], 201);
        });
    }
}
