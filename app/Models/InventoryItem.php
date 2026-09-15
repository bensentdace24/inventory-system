<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;

    protected $table = 'inventory_items';

    protected $fillable = [
        'asset_serial_number',
        'item_description',
        'acquisition_date',
        'cost',
        'quantity',
        'remaining_quantity',
        'date_of_withdrawal',
        'date_of_returned',
        'salvage_value',
        'custodian',
        'depreciation_expense',
        'book_value',
        'status',
        'status_remarks',
    ];

    protected $casts = [
        'acquisition_date' => 'date:Y-m-d',
        'date_of_withdrawal' => 'date:Y-m-d',
        'date_of_returned' => 'date:Y-m-d',

        'cost' => 'decimal:2',
        'salvage_value' => 'decimal:2',
        'depreciation_expense' => 'decimal:2',
        'book_value' => 'decimal:2',

        'quantity' => 'integer',
        'remaining_quantity' => 'integer',
    ];

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function stockIns()
    {
        return $this->hasMany(StockIn::class);
    }

    public function returns()
    {
        return $this->hasMany(ItemReturn::class);
    }
}
