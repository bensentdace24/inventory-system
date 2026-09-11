<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\StockIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockInController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'stock_in_date' => 'required|date',
            'remarks' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($validated) {
            $item = Item::lockForUpdate()->findOrFail($validated['item_id']);

            // Increase master item quantity[cite: 1]
            $item->quantity += $validated['quantity'];
            $item->save();

            $stockIn = StockIn::create($validated);

            return response()->json([
                'message' => 'Stock added successfully',
                'item' => $item,
                'stock_in' => $stockIn
            ], 201);
        });
    }
}
