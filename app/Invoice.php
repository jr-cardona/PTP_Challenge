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

    public function seller(){
        return $this->belongsTo(Seller::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class)->withTimestamps()->withPivot('quantity', 'unit_price');
    }

    public function state(){
        return $this->belongsTo(State::class);
    }

    public function getSubtotalAttribute(){
        $subtotal = 0;
        foreach($this->products as $product){
            $subtotal += $product->pivot->unit_price * $product->pivot->quantity;
        }
        return $subtotal;
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
