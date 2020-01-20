<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    protected $guarded = [];

    /**
     * Relation between clients and invoices
     * @return HasMany
     */
    public function invoices(): HasMany {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Relation between clients and type documents
     * @return BelongsTo
     */
    public function type_document(): BelongsTo {
        return $this->belongsTo(TypeDocument::class);
    }

    /** Mutator */
    public function setEmailAttribute($value) {
        $this->attributes['email'] = strtolower($value);
    }

    /** Query Scopes */
    public function scopeClient($query, $id) {
        if(trim($id) != ""){
            return $query->where('id', $id);
        }
    }

    public function scopeTypeDocument($query, $type_document_id) {
        if(trim($type_document_id) != ""){
            return $query->where('type_document_id', $type_document_id);
        }
    }

    public function scopeDocument($query, $document) {
        if(trim($document) != ""){
            return $query->where('document', 'LIKE', "%$document%");
        }
    }

    public function scopeEmail($query, $email) {
        if(trim($email) != ""){
            return $query->where('email', 'LIKE', "%$email%");
        }
    }

    /** Derived attributes */
    public function getFullNameAttribute(){
        return $this->name . " " . $this->surname;
    }
}
