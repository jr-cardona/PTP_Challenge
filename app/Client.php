<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [];

    public function invoices(){
        return $this->hasMany(Invoice::class);
    }

    public function type_document(){
        return $this->belongsTo(TypeDocument::class);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }
}
