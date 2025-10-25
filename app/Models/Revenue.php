<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'counselor_id',
        'lead_id',
        'date',
        'amount',
        'payment_mode',
        'transaction_id',
        'receipt_number',
        'course_type',
        'payment_type',
        'installment_number',
        'total_installments',
        'discount_applied',
        'notes',
        'status',
        'collected_by',
        'verified_by',
        'verified_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
        'discount_applied' => 'decimal:2',
        'installment_number' => 'integer',
        'total_installments' => 'integer',
        'verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the counselor associated with this revenue.
     */
    public function counselor()
    {
        return $this->belongsTo(Counselor::class, 'counselor_id');
    }

    /**
     * Get the lead associated with this revenue.
     */
    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    /**
     * Get the user who collected this revenue.
     */
    public function collectedBy()
    {
        return $this->belongsTo(User::class, 'collected_by');
    }

    /**
     * Get the user who verified this revenue.
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Scope to get revenues by counselor.
     */
    public function scopeByCounselor($query, $counselorId)
    {
        return $query->where('counselor_id', $counselorId);
    }

    /**
     * Scope to get revenues by date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    /**
     * Scope to get revenues by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to get confirmed revenues only.
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'Confirmed');
    }

    /**
     * Scope to get pending revenues only.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    /**
     * Get the net amount after discount.
     */
    public function getNetAmountAttribute()
    {
        return $this->amount - ($this->discount_applied ?? 0);
    }

    /**
     * Generate next receipt number.
     */
    public static function generateReceiptNumber()
    {
        $lastReceipt = self::orderBy('id', 'desc')->first();
        $nextNumber = $lastReceipt ? ((int) substr($lastReceipt->receipt_number, -6)) + 1 : 1;
        return 'RCP-' . date('Ymd') . '-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Check if revenue is editable.
     */
    public function isEditable()
    {
        return in_array($this->status, ['Pending', 'Confirmed']);
    }

    /**
     * Check if revenue is deletable.
     */
    public function isDeletable()
    {
        // Allow deleting all revenues regardless of status
        return true;
    }
}
