<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $guarded = [];

    /**
     * Relation between products and invoices
     * @return BelongsToMany
     */
    public function invoices(): BelongsToMany
    {
        return $this->belongsToMany(Invoice::class);
    }

    /**
     * Relation between products and users
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Query Scopes */
    public function scopeId($query, $id)
    {
        if (trim($id) !== '') {
            return $query->where('id', $id);
        }
    }

    public function scopeOwner($query)
    {
        if (auth()->user()->hasPermissionTo('View any products') || auth()->user()->hasRole('Admin')) {
            return $query;
        } elseif (auth()->user()->hasPermissionTo('View products')) {
            $query->where('owner_id', auth()->user()->id);
        } else {
            return $query->where('owner_id', '-1');
        }
    }
}
