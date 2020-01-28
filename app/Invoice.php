<?php

namespace App;

use App\Events\InvoiceCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Invoice extends Model
{
    protected $guarded = [];
    protected $dates = [
        'issued_at',
        'expired_at',
        'received_at'
    ];
    protected $casts = [
        'issued_at' => 'datetime:Y-m-d',
        'expired_at' => 'datetime:Y-m-d',
        'received_at' => 'datetime:Y-m-d',
    ];
    protected $dispatchesEvents = [
        'created' => InvoiceCreated::class,
    ];

    /**
     * Relation between invoices and clients
     * @return BelongsTo
     */
    public function client(): BelongsTo {
        return $this->belongsTo(Client::class);
    }

    /**
     * Relation between invoices and sellers
     * @return BelongsTo
     */
    public function seller(): BelongsTo {
        return $this->belongsTo(Seller::class);
    }

    /**
     * Relation between invoices and products
     * @return BelongsToMany
     */
    public function products(): BelongsToMany {
        return $this->belongsToMany(Product::class)->withTimestamps()->withPivot('quantity', 'unit_price')->orderBy('id');
    }

    /**
     * Relation between invoices and states
     * @return BelongsTo
     */
    public function state(): BelongsTo {
        return $this->belongsTo(State::class);
    }

    /**
     * Relation between invoices and paymentAttempts
     * @return HasMany
     */
    public function payment_attempts(): HasMany {
        return $this->hasMany(PaymentAttempt::class);
    }

    /** DERIVED ATTRIBUTES */
    public function isExpired()
    {
        return $this->state_id == 3;
    }

    public function isPaid()
    {
        return $this->state_id == 2;
    }

    public function isPending()
    {
        return $this->state_id == 1;
    }

    public function getSubtotalAttribute() {
        $subtotal = 0;
        foreach($this->products as $product){
            $subtotal += $product->pivot->unit_price * $product->pivot->quantity;
        }
        return $subtotal;
    }

    public function getIvaAmountAttribute() {
        return $this->getSubtotalAttribute() * $this->vat / 100;
    }

    public function getTotalAttribute() {
        return $this->getSubtotalAttribute() + $this->getIvaAmountAttribute();
    }

    public function getIssuedAttribute() {
        return isset($this->issued_at) ? $this->issued_at->toDateString() : '';
    }

    public function getFullNameAttribute(){
        return __("Factura de venta No. ").str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }

    /** Query Scopes */
    public function scopeNumber($query, $number) {
        if(trim($number) != "") {
            return $query->where('id', 'LIKE', "%$number%");
        }
    }

    public function scopeState($query, $state_id) {
        if(trim($state_id) != "") {
            return $query->where('state_id', $state_id);
        }
    }

    public function scopeClient($query, $client_id) {
        if(trim($client_id) != "") {
            return $query->where('client_id', $client_id);
        }
    }

    public function scopeSeller($query, $seller_id) {
        if(trim($seller_id) != "") {
            return $query->where('seller_id', $seller_id);
        }
    }
    public function scopeProduct($query, $product_id) {
        if(trim($product_id) != "") {
            return $query->whereHas('products', function (Builder $query) use ($product_id) {
                $query->where('product_id', $product_id);
            });
        }
    }

    public function scopeIssuedDate($query, $issued_init, $issued_final) {
        if(trim($issued_init) != "" && trim($issued_final) != "") {
            return $query->whereBetween('issued_at', [$issued_init, $issued_final]);
        }
    }
}
