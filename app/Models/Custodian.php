<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Custodian extends Model
{
    protected $fillable = ['name', 'office', 'position'];

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function itemReturns()
    {
        return $this->hasMany(ItemReturn::class);
    }
}
