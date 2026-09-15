<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemReturn extends Model
{
    protected $table = 'item_returns';

    protected $fillable = [
        'inventory_item_id',
        'custodian_id',
        'quantity',
        'return_date',
        'condition',
        'remarks',
    ];

    protected $casts = [
        'return_date' => 'date:Y-m-d',
        'quantity' => 'integer',
    ];

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class);
    }

    public function custodian()
    {
        return $this->belongsTo(Custodian::class);
    }
}
