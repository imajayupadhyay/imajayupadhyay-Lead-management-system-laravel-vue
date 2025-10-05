<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'lead_id',
        'counselor_id',
        'follow_up_date',
        'follow_up_time',
        'status',
        'contact_method',
        'notes',
        'outcome',
        'next_follow_up_date',
        'priority',
        'completed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'follow_up_date' => 'date',
        'next_follow_up_date' => 'date',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the lead that owns the follow-up.
     */
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    /**
     * Get the counselor that owns the follow-up.
     */
    public function counselor()
    {
        return $this->belongsTo(Counselor::class);
    }

    /**
     * Scope a query to only include pending follow-ups.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    /**
     * Scope a query to only include completed follow-ups.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'Completed');
    }

    /**
     * Scope a query to only include today's follow-ups.
     */
    public function scopeToday($query)
    {
        return $query->whereDate('follow_up_date', today());
    }

    /**
     * Scope a query to only include overdue follow-ups.
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'Pending')
                     ->where('follow_up_date', '<', today());
    }

    /**
     * Scope a query to only include upcoming follow-ups.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('status', 'Pending')
                     ->where('follow_up_date', '>', today());
    }

    /**
     * Scope a query for a specific counselor.
     */
    public function scopeForCounselor($query, $counselorId)
    {
        return $query->where('counselor_id', $counselorId);
    }
}
