<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentAttempt extends Model
{
    protected $guarded = [];

    /**
     * Relation between paymentAttempts and invoices
     * @return BelongsTo
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Relation between invoices and updaters
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

    public function getReadableStatusAttribute()
    {
        $status = $this->attributes['status'];
        return [
            'FAILED' => 'Fallido',
            'APPROVED' => 'Aprobado',
            'REJECTED' => 'Rechazado',
            'PENDING' => 'Pendiente',
        ][$status];
    }

    public function isFailed()
    {
        return $this->status === 'FAILED';
    }

    public function isApproved()
    {
        return $this->status === 'APPROVED';
    }

    public function isRejected()
    {
        return $this->status === 'REJECTED';
    }

    public function isPending()
    {
        return $this->status === 'PENDING';
    }
}
