<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = ['item_id', 'custodian_id', 'quantity', 'withdrawal_date', 'purpose', 'remarks'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function custodian()
    {
        return $this->belongsTo(Custodian::class);
    }
}
