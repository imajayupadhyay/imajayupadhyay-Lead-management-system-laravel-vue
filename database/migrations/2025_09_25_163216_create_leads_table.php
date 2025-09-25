<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            
            // Basic Information
            $table->date('enquiry_date');
            $table->string('student_name');
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->integer('age')->nullable();
            $table->string('mobile_number');
            $table->string('email')->nullable();
            
            // Address Information
            $table->text('address');
            $table->string('pin_code', 10);
            $table->string('state');
            
            // Academic Information
            $table->string('qualification');
            $table->string('college')->nullable();
            
            // Visit Information
            $table->enum('visited_with', ['Self', 'Parent/Friend']);
            $table->string('parent_friend_name')->nullable(); // When visited with Parent/Friend
            $table->string('parent_occupation')->nullable();
            
            // Course Interest - Store as JSON for multiple selections
            $table->json('interested_courses')->nullable(); // Will store array of selected courses
            $table->string('course_duration')->nullable(); // 1-Year, 2-Year, 3-Year
            $table->string('course_language')->nullable(); // Bilingual, English, Hindi
            $table->string('course_type')->nullable(); // NCERT/A-125/S-50
            $table->text('gs_module_details')->nullable(); // CSAT/Essay/Ethics etc.
            $table->text('optional_subject')->nullable();
            $table->text('other_query')->nullable();
            $table->string('target_year')->nullable();
            
            // Lead Management Fields
            $table->enum('status', [
                'New',
                'Contacted', 
                'Interested',
                'Not Interested',
                'Enrolled',
                'Lost'
            ])->default('New');
            $table->enum('priority', ['High', 'Medium', 'Low'])->default('Medium');
            $table->string('lead_source')->default('Website Form');
            
            // Office Use Only Fields
            $table->string('enquiry_by')->nullable(); // Staff member who handled enquiry
            $table->foreignId('counselor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('visited_class')->default(false);
            $table->boolean('demo_attended')->default(false);
            $table->string('faculty_assigned')->nullable();
            
            // Follow-up tracking
            $table->datetime('last_contacted_at')->nullable();
            $table->datetime('next_follow_up_date')->nullable();
            $table->text('notes')->nullable(); // General notes about the lead
            
            // Meta Information
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referrer_url')->nullable();
            
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['status', 'created_at']);
            $table->index(['counselor_id', 'status']);
            $table->index(['next_follow_up_date']);
            $table->index(['mobile_number']);
            $table->index(['email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};