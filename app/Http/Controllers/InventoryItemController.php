<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use Illuminate\Http\Request;

class InventoryItemController extends Controller
{
    public function index()
    {
        return response()->json(
            InventoryItem::orderBy('created_at', 'desc')->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_serial_number' => 'required|string|unique:inventory_items,asset_serial_number',
            'item_description' => 'required|string',
            'acquisition_date' => 'required|date',
            'cost' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'salvage_value' => 'nullable|numeric|min:0',
            'depreciation_expense' => 'nullable|numeric|min:0',
            'book_value' => 'nullable|numeric|min:0',
            'custodian' => 'nullable|string',
            'status_remarks' => 'nullable|string',
        ]);

        // New inventory starts with all quantity available.
        $validated['remaining_quantity'] = $validated['quantity'];

        // Automatically calculate book value when blank.
        $validated['book_value'] =
            $validated['book_value']
            ?? (
                $validated['cost']
                - ($validated['depreciation_expense'] ?? 0)
            );

        $item = InventoryItem::create($validated);

        return response()->json($item, 201);
    }

    public function show($id)
    {
        return response()->json(
            InventoryItem::findOrFail($id)
        );
    }

    public function update(Request $request, $id)
    {
        $item = InventoryItem::findOrFail($id);

        $validated = $request->validate([
            'asset_serial_number' => 'required|string|unique:inventory_items,asset_serial_number,' . $id,
            'item_description' => 'required|string',
            'acquisition_date' => 'required|date',
            'cost' => 'required|numeric|min:0',
            'salvage_value' => 'nullable|numeric|min:0',
            'depreciation_expense' => 'nullable|numeric|min:0',
            'book_value' => 'nullable|numeric|min:0',
            'custodian' => 'nullable|string',
            'status_remarks' => 'nullable|string',
        ]);

        $item->update($validated);

        return response()->json($item);
    }

    public function destroy($id)
    {
        InventoryItem::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
