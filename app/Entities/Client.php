<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    protected $fillable = [
        'document',
        'type_document_id',
        'phone',
        'cellphone',
        'address',
        'user_id',
    ];

    protected $with = ['user.creator'];

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
    public function getCreatorAttribute()
    {
        return $this->user->creator ?? '';
    }
    public function getUpdaterAttribute()
    {
        return $this->user->updater ?? '';
    }

    /** Query Scopes */
    public function scopeId($query, $id)
    {
        if (auth()->user()->can('View any clients') ||
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

    public function scopeEmail($query, $email)
    {
        if (trim($email) !== '') {
            return $query->where('email', 'LIKE', "%${email}%");
        }
    }
}