<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = [
        'inventory_item_id',
        'custodian_id',
        'quantity',
        'withdrawal_date',
        'purpose',
        'remarks',
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
