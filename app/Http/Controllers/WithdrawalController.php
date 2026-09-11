<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'custodian_id' => 'required|exists:custodians,id',
            'quantity' => 'required|integer|min:1',
            'withdrawal_date' => 'required|date',
            'purpose' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        // Database Transaction Failsafe Block[cite: 1]
        return DB::transaction(function () use ($validated) {
            $item = Item::lockForUpdate()->findOrFail($validated['item_id']);

            if ($item->quantity < $validated['quantity']) {
                return response()->json([
                    'error' => 'Insufficient stock. Available quantity: ' . $item->quantity
                ], 422);
            }

            // Deduct quantity from master record[cite: 1]
            $item->quantity -= $validated['quantity'];
            $item->save();

            // Create the audit trail record[cite: 1]
            $withdrawal = Withdrawal::create($validated);

            return response()->json([
                'message' => 'Withdrawal processed successfully',
                'item' => $item,
                'withdrawal' => $withdrawal
            ], 201);
        });
    }
}
