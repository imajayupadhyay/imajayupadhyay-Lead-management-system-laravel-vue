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
        'enquiry_by',
        'marketer_id',
        'counselor_id',
        'visited_class',
        'demo_attended',
        'faculty_id',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
        'interested_in' => 'array',
        'visited_class' => 'boolean',
        'demo_attended' => 'boolean',
    ];

    // Relationships
    public function counselor()
    {
        return $this->belongsTo(Counselor::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function marketer()
    {
        return $this->belongsTo(Marketer::class);
    }
}