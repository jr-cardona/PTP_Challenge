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
     * Relation between invoices and users
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation between invoices and products
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withTimestamps()
            ->withPivot('quantity', 'unit_price')
            ->orderBy('id');
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
        return ($this->expires_at <= Carbon::now() && ! $this->isPaid());
    }

    public function isPaid()
    {
        return (! empty($this->paid_at));
    }

    public function isPending()
    {
        return (! $this->isPaid() && ! $this->isExpired());
    }

    public function isAnnulled()
    {
        return (! empty($this->annulled_at));
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
        return ($this->issued_at ?? Carbon::now())->toDateString();
    }

    public function getFullNameAttribute()
    {
        return __("Factura de venta No. ").str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }

    public function getStateAttribute(){
        if ($this->isAnnulled()) {
            return "Anulada";
        }
        if ($this->isExpired()) {
            return "Vencida";
        }
        if ($this->isPaid()) {
            return "Pagada";
        }
        if ($this->isPending()) {
            return "Pendiente";
        }
    }

    /** Query Scopes */
    public function scopeNumber($query, $number)
    {
        if (trim($number) !== '') {
            return $query->where('id', 'LIKE', "%${number}%");
        }
    }

    public function scopeClient($query, $clientId)
    {
        if (trim($clientId) !== '') {
            return $query->where('client_id', $clientId);
        }
    }

    public function scopeCreator($query, $creatorId)
    {
        if (auth()->user()->hasPermissionTo('View any invoices') || auth()->user()->hasRole('Admin')) {
            if (trim($creatorId) !== '') {
                return $query->where('creator_id', $creatorId);
            }
            return $query;
        }
        if (auth()->user()->hasPermissionTo('View invoices')) {
            if (auth()->user()->hasRole('Client')) {
                return $query->where('client_id', auth()->user()->client->id);
            } else {
                return $query->where('creator_id', auth()->user()->id);
            }
        }
        return $query->where('creator_id', '-1');
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
        if (trim($state) === "annulled") {
            return $query->whereNotNull('annulled_at');
        }
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
