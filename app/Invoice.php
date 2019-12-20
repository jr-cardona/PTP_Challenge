<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];

    //ELOQUENT RELATIONSHIPS
    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function seller(){
        return $this->belongsTo(Seller::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class)->withTimestamps()->withPivot('quantity', 'unit_price')->orderBy('id');
    }

    public function state(){
        return $this->belongsTo(State::class);
    }

    //DERIVED ATTRIBUTES
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

    //QUERY SCOPES
    public function scopeNumber($query, $number){
        if(trim($number) != ""){
            return $query->where('number', 'LIKE', "%$number%");
        }
    }

    public function scopeState($query, $state_id){
        if(trim($state_id) != ""){
            return $query->where('state_id', $state_id);
        }
    }

    public function scopeClient($query, $client_id){
        if(trim($client_id) != ""){
            return $query->where('client_id', $client_id);
        }
    }

    public function scopeSeller($query, $seller_id){
        if(trim($seller_id) != ""){
            return $query->where('seller_id', $seller_id);
        }
    }
    public function scopeProduct($query, $product_id){
        if(trim($product_id) != ""){
            return $query->whereHas('products', function (Builder $query) use ($product_id) {
                $query->where('product_id', $product_id);
            });
        }
    }

    public function scopeIssuedDate($query, $issued_init, $issued_final){
        if(trim($issued_init) != "" && trim($issued_final) != ""){
            return $query->whereBetween('issued_at', [$issued_init, $issued_final]);
        }
    }

    public function scopeOverduedDate($query, $overdued_init, $overdued_final){
        if(trim($overdued_init) != "" && trim($overdued_final) != ""){
            return $query->whereBetween('overdued_at', [$overdued_init, $overdued_final]);
        }
    }

    public function save(array $options = []){
        if(parent::save($options)) {
            $this->number = str_pad($this->id, 5, "0", STR_PAD_LEFT);
            parent::save();
        }
    }
}
