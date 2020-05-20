<?php

namespace App\Entities;

use Config;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Invoice extends Model
{
    protected $fillable = [
        'issued_at',
        'client_id',
        'description',
        'created_by',
        'updated_by',
        'expires_at',
    ];

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

    protected $perPage = 10;

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
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relation between invoices and updaters
     * @return BelongsTo
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
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

    /** Getters */
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

    public function getStateAttribute()
    {
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

    // Scopes
    public function scopeAllSellers($query, $sellerId)
    {
        if (trim($sellerId)) {
            return $query->where('created_by', $sellerId);
        }
    }

    public function scopeAllClients($query, $clientId)
    {
        if (trim($clientId)) {
            return $query->where('client_id', $clientId);
        }
    }

    public function scopeSellerId($query, $authUser)
    {
        return $query->where('created_by', $authUser->id);
    }

    public function scopeClientId($query, $authUser)
    {
        return $query->where('client_id', $authUser->id);
    }

    public function scopeNumber($query, $number)
    {
        if (trim($number)) {
            return $query->where('id', 'LIKE', "%${number}%");
        }
    }

    public function scopeProduct($query, $product_id)
    {
        if (trim($product_id)) {
            return $query->whereHas(
                'products',
                static function (Builder $query) use ($product_id) {
                    $query->where('product_id', $product_id);
                }
            );
        }
    }

    public function scopeIssuedDate($query, $issued_init, $issued_final)
    {
        if (trim($issued_init) && trim($issued_final)) {
            return $query->whereBetween('issued_at', [$issued_init, $issued_final]);
        }
    }

    public function scopeExpiresDate($query, $expires_init, $expires_final)
    {
        if (trim($expires_init) && trim($expires_final)) {
            return $query->whereBetween('expires_at', [$expires_init, $expires_final]);
        }
    }

    public function scopeState($query, $state)
    {
        if (trim($state) === 'annulled') {
            return $query->whereNotNull('annulled_at');
        }
        if (trim($state) === 'paid') {
            return $query->whereNotNull('paid_at');
        }
        if (trim($state) === 'expired') {
            return $query->whereDate('expires_at', '<=', Carbon::now())
                ->whereNull('paid_at');
        }
        if (trim($state) === 'pending') {
            return $query->whereNull('annulled_at')
                ->whereNull('paid_at')
                ->whereDate('expires_at', '>', Carbon::now());
        }
    }
}
