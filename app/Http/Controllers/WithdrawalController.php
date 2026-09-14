<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inventory_item_id' => 'required|exists:inventory_items,id',
            'custodian_id' => 'required|exists:custodians,id',
            'quantity' => 'required|integer|min:1',
            'withdrawal_date' => 'required|date',
            'purpose' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($validated) {
            $item = InventoryItem::lockForUpdate()
                ->findOrFail($validated['inventory_item_id']);

            if ($item->remaining_quantity < $validated['quantity']) {
                return response()->json([
                    'message' => 'Insufficient stock.',
                    'error' => 'Available quantity: ' . $item->remaining_quantity,
                ], 422);
            }

            $item->remaining_quantity -= $validated['quantity'];
            $item->date_of_withdrawal = $validated['withdrawal_date'];
            $item->save();

            $withdrawal = Withdrawal::create($validated);

            return response()->json([
                'message' => 'Withdrawal processed successfully.',
                'item' => $item,
                'withdrawal' => $withdrawal,
            ], 201);
        });
    }
}
