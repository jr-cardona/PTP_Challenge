<?php

namespace App;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'creator_id', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relation between users and invoices
     * @return HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'creator_id');
    }

    /**
     * Relation between users and products
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'creator_id');
    }

    /**
     * Relation between users and clients
     * @return HasOne
     */
    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }

    /**
     * Relation between users and users
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'creator_id');
    }

    /**
     * Relation between users and users
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Derived attributes */
    public function getFullNameAttribute()
    {
        return $this->name . " " . $this->surname;
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
}
