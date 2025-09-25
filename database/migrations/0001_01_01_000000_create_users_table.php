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
            
            // Form Data - Exactly matching the enquiry form
            $table->date('date');
            $table->string('student_name');
            $table->enum('gender', ['Male', 'Female', 'Trans'])->nullable();
            $table->integer('age')->nullable();
            $table->string('mobile_number');
            $table->string('email')->nullable();
            $table->text('address');
            $table->string('pin_code', 10);
            $table->string('state');
            $table->string('qualification');
            $table->string('college')->nullable();
            
            // Visit Information
            $table->enum('visited_with', ['Self', 'Parent/Friend']);
            $table->string('parent_friend_specify')->nullable(); // When visited with Parent/Friend
            $table->string('parent_occupation')->nullable();
            
            // Course Interest - Store as JSON for checkbox selections
            $table->json('interested_in')->nullable(); // Will store selected course types
            $table->string('course_duration')->nullable(); // 1-Year, 2-Year, 3-Year
            $table->string('course_language')->nullable(); // Bilingual, English, Hindi
            $table->string('course_type_details')->nullable(); // NCERT/A-125/S-50 details
            $table->string('gs_module')->nullable(); // CSAT/Essay/Ethics etc.
            $table->string('optional_subject')->nullable();
            $table->text('other_query')->nullable();
            $table->string('target_year')->nullable();
            
            // Office Use Only Fields - Dynamic Relations
            $table->string('enquiry_by')->nullable(); // Free text or from dropdown
            $table->foreignId('counselor_id')->nullable()->constrained('counselors')->onDelete('set null');
            $table->boolean('visited_class')->default(false);
            $table->boolean('demo_attended')->default(false);
            $table->foreignId('faculty_id')->nullable()->constrained('faculty')->onDelete('set null');
            
            // Basic lead status
            $table->enum('status', ['New', 'Contacted', 'Interested', 'Not Interested', 'Enrolled'])->default('New');
            
            $table->timestamps();
            
            // Basic indexes
            $table->index(['mobile_number']);
            $table->index(['email']);
            $table->index(['status']);
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