<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\ItemReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inventory_item_id' => 'required|exists:inventory_items,id',
            'custodian_id' => 'required|exists:custodians,id',
            'quantity' => 'required|integer|min:1',
            'return_date' => 'required|date',
            'condition' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($validated) {

            $item = InventoryItem::lockForUpdate()
                ->findOrFail($validated['inventory_item_id']);

            $item->remaining_quantity += $validated['quantity'];
            $item->date_of_returned = $validated['return_date'];

            $item->save();

            $itemReturn = ItemReturn::create($validated);

            return response()->json([
                'message' => 'Return processed successfully.',
                'item' => $item,
                'return' => $itemReturn,
            ], 201);
        });
    }
}
