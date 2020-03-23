<?php

namespace App\Entities;

use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles;

    protected $fillable = [
        'name', 'surname', 'email', 'created_by', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relation between users and invoices
     * @return HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'created_by');
    }

    /**
     * Relation between users and products
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'created_by');
    }

    /**
     * Relation between users and clients
     * @return HasOne
     */
    public function client(): HasOne
    {
        return $this->hasOne(Client::class, 'id');
    }

    /**
     * Relation between users and users
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'created_by');
    }

    /**
     * Relation between users and users
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relation between users and users
     * @return BelongsTo
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /** Derived attributes */
    public function getFullNameAttribute()
    {
        return $this->name . " " . $this->surname;
    }

    /** Mutators */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = strtolower($email);
    }

    /** Query Scopes */
    public function scopeId($query, $id)
    {
        if (trim($id) !== "") {
            return $query->where('id', $id);
        }
    }

    public function scopeEmail($query, $email)
    {
        if (trim($email) !== '') {
            return $query->where('email', 'LIKE', "%${email}%");
        }
    }

    public function canBeDeleted(){
        return empty($this->invoices->first()) && empty($this->products->first())
            && empty($this->users->first()) && empty($this->client);
    }

    public function isClient(){
        return isset($this->client);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
