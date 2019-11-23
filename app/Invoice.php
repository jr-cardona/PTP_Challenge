<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class)->withTimestamps()->withPivot('quantity', 'unit_price', 'total_price');
    }

    public function getSubtotalAttribute(){
        if (isset($this->products[0])){
            return $this->products[0]->pivot
                ->where('invoice_id', $this->id)
                ->sum('total_price');
        }else{
            return 0;
        }
    }

    public function getIvaAmountAttribute(){
        return $this->getSubtotalAttribute() * $this->vat / 100;
    }

    public function getTotalAttribute(){
        return $this->getSubtotalAttribute() + $this->getIvaAmountAttribute();
    }

    public function getDateAttribute($date){
        if (! empty($date)){
            return date_format(date_create($date), 'Y-m-d\TH:i:s');
        }else{
            return "";
        }
    }
}
