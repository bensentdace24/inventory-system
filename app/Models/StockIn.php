<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    protected $fillable = [
        'inventory_item_id',
        'quantity',
        'stock_in_date',
        'remarks',
    ];

    protected $casts = [
        'stock_in_date' => 'date:Y-m-d',
        'quantity' => 'integer',
    ];

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class);
    }
}
