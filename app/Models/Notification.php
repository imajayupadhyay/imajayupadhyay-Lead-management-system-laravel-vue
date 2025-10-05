<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'counselor_id',
        'type',
        'title',
        'message',
        'data',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    /**
     * Get the counselor that owns the notification.
     */
    public function counselor()
    {
        return $this->belongsTo(Counselor::class);
    }

    /**
     * Scope a query to only include unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Scope a query to only include read notifications.
     */
    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    /**
     * Scope a query to filter by counselor.
     */
    public function scopeForCounselor($query, $counselorId)
    {
        return $query->where('counselor_id', $counselorId);
    }

    /**
     * Mark the notification as read.
     */
    public function markAsRead()
    {
        if (is_null($this->read_at)) {
            $this->read_at = now();
            $this->save();
        }
    }

    /**
     * Mark the notification as unread.
     */
    public function markAsUnread()
    {
        if (!is_null($this->read_at)) {
            $this->read_at = null;
            $this->save();
        }
    }

    /**
     * Create a lead assigned notification.
     */
    public static function createLeadAssigned($counselorId, $leadId, $leadName)
    {
        return self::create([
            'counselor_id' => $counselorId,
            'type' => 'lead_assigned',
            'title' => 'New Lead Assigned',
            'message' => "A new lead '{$leadName}' has been assigned to you.",
            'data' => [
                'lead_id' => $leadId,
                'lead_name' => $leadName,
            ],
        ]);
    }

    /**
     * Create a follow-up today notification.
     */
    public static function createFollowUpToday($counselorId, $followUpId, $leadName)
    {
        return self::create([
            'counselor_id' => $counselorId,
            'type' => 'follow_up_today',
            'title' => 'Follow-up Due Today',
            'message' => "You have a follow-up scheduled today with '{$leadName}'.",
            'data' => [
                'follow_up_id' => $followUpId,
                'lead_name' => $leadName,
            ],
        ]);
    }

    /**
     * Create a follow-up overdue notification.
     */
    public static function createFollowUpOverdue($counselorId, $followUpId, $leadName)
    {
        return self::create([
            'counselor_id' => $counselorId,
            'type' => 'follow_up_overdue',
            'title' => 'Overdue Follow-up',
            'message' => "Your follow-up with '{$leadName}' is overdue.",
            'data' => [
                'follow_up_id' => $followUpId,
                'lead_name' => $leadName,
            ],
        ]);
    }
}
