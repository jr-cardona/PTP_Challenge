<?php

namespace App\Entities;

use App\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'cost',
        'price',
        'created_by',
        'updated_by',
    ];

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
    public function creator(): BelongsTo
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

    /** Query Scopes */
    public function scopeId($query, $id)
    {
        if (trim($id) !== '') {
            return $query->where('id', $id);
        }
    }

    public function scopeCreator($query)
    {
        if (auth()->user()->can('View any products') || auth()->user()->hasRole('SuperAdmin')) {
            return $query;
        } elseif (auth()->user()->hasPermissionTo('View products')) {
            $query->where('created_by', auth()->user()->id);
        } else {
            return $query->where('created_by', '-1');
        }
    }
}
