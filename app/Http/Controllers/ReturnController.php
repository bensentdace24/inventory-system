<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'custodian_id' => 'required|exists:custodians,id',
            'quantity' => 'required|integer|min:1',
            'return_date' => 'required|date',
            'condition' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($validated) {
            $item = Item::lockForUpdate()->findOrFail($validated['item_id']);

            // Increase master item quantity back upon return[cite: 1]
            $item->quantity += $validated['quantity'];
            $item->save();

            // Create the return audit trail record[cite: 1]
            $itemReturn = ItemReturn::create($validated);

            return response()->json([
                'message' => 'Return processed successfully',
                'item' => $item,
                'return' => $itemReturn
            ], 201);
        });
    }
}
