<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    protected $fillable = ['item_id', 'quantity', 'stock_in_date', 'remarks'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
