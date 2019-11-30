<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    protected $guarded = [];

    //ELOQUENT RELATIONSHIPS
    public function invoices(){
        return $this->belongsToMany(Invoice::class);
    }

    //QUERY SCOPES
    public function scopeProduct($query, $id){
        if(trim($id) != ""){
            return $query->where('id', $id);
        }
    }
}
