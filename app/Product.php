<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function invoices(){
        return $this->belongsToMany(Invoice::class);
    }
}
