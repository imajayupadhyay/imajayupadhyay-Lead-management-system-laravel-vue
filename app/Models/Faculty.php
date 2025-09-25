<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $table = 'faculty'; // Explicitly define table name

    protected $fillable = [
        'name',
        'subject',
        'email',
        'phone',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessor for display name with subject
    public function getDisplayNameAttribute()
    {
        return $this->subject ? "{$this->name} ({$this->subject})" : $this->name;
    }
}