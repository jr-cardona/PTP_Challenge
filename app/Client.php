<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [];

    //ELOQUENT RELATIONSHIPS
    public function invoices(){
        return $this->hasMany(Invoice::class);
    }

    public function type_document(){
        return $this->belongsTo(TypeDocument::class);
    }

    //DERIVED ATTRIBUTES
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    //QUERY SCOPES
    public function scopeClient($query, $id){
        if(trim($id) != ""){
            return $query->where('id', $id);
        }
    }

    public function scopeTypeDocument($query, $type_document_id){
        if(trim($type_document_id) != ""){
            return $query->where('type_document_id', $type_document_id);
        }
    }

    public function scopeDocument($query, $document){
        if(trim($document) != ""){
            return $query->where('document', 'LIKE', "%$document%");
        }
    }

    public function scopeEmail($query, $email){
        if(trim($email) != ""){
            return $query->where('email', 'LIKE', "%$email%");
        }
    }
}
