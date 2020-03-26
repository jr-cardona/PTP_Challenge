<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    protected $fillable = [
        'id',
        'document',
        'type_document_id',
        'phone',
        'cellphone',
        'address',
        'created_by',
        'updated_by',
    ];

    public $incrementing = false;

    /**
     * Relation between clients and invoices
     * @return HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Relation between clients and users
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
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

    /**
     * Relation between clients and type documents
     * @return BelongsTo
     */
    public function type_document(): BelongsTo
    {
        return $this->belongsTo(TypeDocument::class);
    }

    /** Derived attributes */
    public function getNameAttribute()
    {
        return $this->user->name ?? '';
    }
    public function getSurnameAttribute()
    {
        return $this->user->surname ?? '';
    }
    public function getFullNameAttribute()
    {
        return $this->user->fullname ?? '';
    }
    public function getEmailAttribute()
    {
        return $this->user->email ?? '';
    }

    /** Query Scopes */
    public function scopeId($query, $id)
    {
        if (auth()->user()->can('View all clients') ||
            auth()->user()->hasRole('SuperAdmin')) {
            if (trim($id) !== '') {
                return $query->where('id', $id);
            }
            return $query;
        }
        return $query->where('id', '-1');
    }

    public function scopeTypeDocument($query, $type_document_id)
    {
        if (trim($type_document_id) !== '') {
            return $query->where('type_document_id', $type_document_id);
        }
    }

    public function scopeDocument($query, $document)
    {
        if (trim($document) !== '') {
            return $query->where('document', 'LIKE', "%${document}%");
        }
    }

    public function scopeCellphone($query, $cellphone)
    {
        if (trim($cellphone) !== '') {
            return $query->where('cellphone', 'LIKE', "%${cellphone}%");
        }
    }

    public function scopeEmail($query, $email)
    {
        if (trim($email) !== '') {
            return $query->whereHas(
                'user',
                static function (Builder $query) use ($email) {
                    $query->where('email', 'like', "%${email}%");
                }
            );
        }
    }

    public function canBeDeleted()
    {
        return empty($this->invoices->first());
    }
}
