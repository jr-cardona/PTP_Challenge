<?php

namespace App;

use Config;
use Carbon\Carbon;
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
        'expires_at',
        'received_at',
        'paid_at',
    ];
    protected $casts = [
        'issued_at' => 'date:Y-m-d',
        'expires_at' => 'date:Y-m-d',
        'received_at' => 'date:Y-m-d',
        'paid_at' => 'date:Y-m-d',
    ];
    protected $dispatchesEvents = [
        'created' => InvoiceCreated::class,
    ];

    /**
     * Relation between invoices and clients
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Relation between invoices and sellers
     * @return BelongsTo
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    /**
     * Relation between invoices and products
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withTimestamps()->withPivot('quantity', 'unit_price')->orderBy('id');
    }

    /**
     * Relation between invoices and paymentAttempts
     * @return HasMany
     */
    public function paymentAttempts(): HasMany
    {
        return $this->hasMany(PaymentAttempt::class);
    }

    /** DERIVED ATTRIBUTES */
    public function isExpired()
    {
        if ($this->expires_at <= Carbon::now() && ! $this->isPaid()) {
            return true;
        } else {
            return false;
        }
    }

    public function isPaid()
    {
        if (! empty($this->paid_at)) {
            return true;
        } else {
            return false;
        }
    }

    public function isPending()
    {
        if (! $this->isPaid() && ! $this->isExpired()) {
            return true;
        } else {
            return false;
        }
    }

    public function isAnnulled()
    {
        if (! empty($this->annulled_at)) {
            return true;
        } else {
            return false;
        }
    }

    public function getSubtotalAttribute()
    {
        $subtotal = 0;
        foreach ($this->products as $product) {
            $subtotal += $product->pivot->unit_price * $product->pivot->quantity;
        }
        return $subtotal;
    }

    public function getIvaAmountAttribute()
    {
        return $this->getSubtotalAttribute() * Config::get('constants.vat') / 100;
    }

    public function getTotalAttribute()
    {
        return $this->getSubtotalAttribute() + $this->getIvaAmountAttribute();
    }

    public function getIssuedAttribute()
    {
        return isset($this->issued_at) ? $this->issued_at->toDateString() : Carbon::now()->toDateString();
    }

    public function getFullNameAttribute()
    {
        return __("Factura de venta No. ").str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }

    /** Query Scopes */
    public function scopeNumber($query, $number)
    {
        if (trim($number) !== '') {
            return $query->where('id', 'LIKE', "%${number}%");
        }
    }

    public function scopeClient($query, $client_id)
    {
        if (trim($client_id) !== '') {
            return $query->where('client_id', $client_id);
        }
    }

    public function scopeSeller($query, $seller_id)
    {
        if (trim($seller_id) !== '') {
            return $query->where('seller_id', $seller_id);
        }
    }

    public function scopeProduct($query, $product_id)
    {
        if (trim($product_id) !== '') {
            return $query->whereHas('products',
                static function (Builder $query) use ($product_id) {
                $query->where('product_id', $product_id);
            });
        }
    }

    public function scopeIssuedDate($query, $issued_init, $issued_final)
    {
        if (trim($issued_init) !== '' && trim($issued_final) !== '') {
            return $query->whereBetween('issued_at', [$issued_init, $issued_final]);
        }
    }

    public function scopeExpiresDate($query, $expires_init, $expires_final)
    {
        if (trim($expires_init) !== '' && trim($expires_final) !== '') {
            return $query->whereBetween('expires_at', [$expires_init, $expires_final]);
        }
    }

    public function scopeState($query, $state)
    {
        if (trim($state) === "paid") {
            return $query->whereNotNull('paid_at');
        }
        if (trim($state) === "expired") {
            return $query->whereDate('expires_at', "<=", Carbon::now())->whereNull('paid_at');
        }
        if (trim($state) === "pending") {
            return $query->whereNull("paid_at")->whereDate('expires_at', ">", Carbon::now());
        }
    }
}
