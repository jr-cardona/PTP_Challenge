<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [];

    public function invoices(){
        return $this->hasMany(Invoice::class);
    }
}
