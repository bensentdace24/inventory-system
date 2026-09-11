<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'category_id',
        'serial_number',
        'description',
        'purchase_date',
        'original_cost',
        'quantity',
        'salvage_value',
        'depreciation_expense',
        'book_value',
        'status',
        'remarks'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function stockIns()
    {
        return $this->hasMany(StockIn::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function itemReturns()
    {
        return $this->hasMany(ItemReturn::class);
    }
}
