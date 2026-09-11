<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemReturn extends Model
{
    protected $table = 'item_returns';

    protected $fillable = ['item_id', 'custodian_id', 'quantity', 'return_date', 'condition', 'remarks'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function custodian()
    {
        return $this->belongsTo(Custodian::class);
    }
}
