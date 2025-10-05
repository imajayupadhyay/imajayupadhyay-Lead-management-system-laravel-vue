<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'student_name',
        'gender',
        'age',
        'mobile_number',
        'email',
        'address',
        'pin_code',
        'state',
        'qualification',
        'college',
        'visited_with',
        'parent_friend_specify',
        'parent_occupation',
        'interested_in',
        'course_language',
        'course_type_details',
        'gs_module',
        'optional_subject',
        'other_query',
        'target_year',
        'feedback',
        'enquiry_by',
        'marketer_id',
        'counselor_id',
        'visited_class',
        'demo_attended',
        'faculty_id',
        'status',
        'lead_category',
        'last_follow_up_date',
        'next_follow_up_date',
        'follow_up_count',
    ];

    protected $casts = [
        'date' => 'date',
        'interested_in' => 'array',
        'visited_class' => 'boolean',
        'demo_attended' => 'boolean',
        'last_follow_up_date' => 'date',
        'next_follow_up_date' => 'date',
    ];

    protected static function booted()
    {
        // Create notification when counselor is assigned or changed
        static::updated(function ($lead) {
            if ($lead->wasChanged('counselor_id') && $lead->counselor_id) {
                \App\Models\Notification::createLeadAssigned(
                    $lead->counselor_id,
                    $lead->id,
                    $lead->student_name
                );
            }
        });

        // Also create notification when lead is created with a counselor
        static::created(function ($lead) {
            if ($lead->counselor_id) {
                \App\Models\Notification::createLeadAssigned(
                    $lead->counselor_id,
                    $lead->id,
                    $lead->student_name
                );
            }
        });
    }

    // Relationships
    public function counselor()
    {
        return $this->belongsTo(Counselor::class, 'counselor_id');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function marketer()
    {
        return $this->belongsTo(Marketer::class);
    }

    public function followUps()
    {
        return $this->hasMany(FollowUp::class);
    }

    public function latestFollowUp()
    {
        return $this->hasOne(FollowUp::class)->latestOfMany('follow_up_date');
    }

    public function nextFollowUp()
    {
        return $this->hasOne(FollowUp::class)
                    ->where('status', 'Pending')
                    ->where('follow_up_date', '>=', now())
                    ->orderBy('follow_up_date', 'asc');
    }

    // Scopes
    public function scopeForCounselor($query, $counselorId)
    {
        return $query->where('counselor_id', $counselorId);
    }

    public function scopeHot($query)
    {
        return $query->where('lead_category', 'Hot');
    }

    public function scopeWarm($query)
    {
        return $query->where('lead_category', 'Warm');
    }

    public function scopeCold($query)
    {
        return $query->where('lead_category', 'Cold');
    }

    // Helper methods
    public function updateLeadCategory()
    {
        if (!$this->last_follow_up_date) {
            $daysSinceCreation = $this->created_at->diffInDays(now());

            if ($daysSinceCreation <= 7) {
                $this->lead_category = 'Hot';
            } elseif ($daysSinceCreation <= 20) {
                $this->lead_category = 'Warm';
            } else {
                $this->lead_category = 'Cold';
            }
        } else {
            $daysSinceLastFollowUp = $this->last_follow_up_date->diffInDays(now());

            if ($daysSinceLastFollowUp <= 7) {
                $this->lead_category = 'Hot';
            } elseif ($daysSinceLastFollowUp <= 20) {
                $this->lead_category = 'Warm';
            } else {
                $this->lead_category = 'Cold';
            }
        }

        $this->save();
    }

    public function getCategoryColorAttribute()
    {
        return match($this->lead_category) {
            'Hot' => 'red',
            'Warm' => 'orange',
            'Cold' => 'blue',
            default => 'gray',
        };
    }

}