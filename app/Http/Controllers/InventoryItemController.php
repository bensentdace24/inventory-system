<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use Illuminate\Http\Request;

class InventoryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(InventoryItem::all());
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_serial_number' => 'required|string|unique:inventory_items',
            'item_description' => 'required|string',
            'acquisition_date' => 'required|date',
            'cost' => 'required|numeric',
            'quantity' => 'required|integer',
            'remaining_quantity' => 'required|integer',
        ]);

        $item = InventoryItem::create($request->all());
        return response()->json($item, 201);
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response()->json(InventoryItem::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InventoryItem $inventoryItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $item = InventoryItem::findOrFail($id);
        $item->update($request->all());
        return response()->json($item);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        InventoryItem::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
