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
            $table->date('date');
            $table->string('student_name');
            $table->enum('gender', ['Male', 'Female', 'Trans'])->nullable();
            $table->integer('age')->nullable();
            $table->string('mobile_number', 15);
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('pin_code', 6)->nullable();
            $table->string('state')->nullable();
            $table->enum('qualification', ['Masters', 'Graduation', '12th']);
            $table->string('college')->nullable();
            $table->enum('visited_with', ['Self', 'Parent/Friend']);
            $table->string('parent_friend_specify')->nullable();
            $table->string('parent_occupation')->nullable();
            $table->json('interested_in')->nullable();
            $table->string('course_language')->nullable();
            $table->string('course_type_details')->nullable();
            $table->string('gs_module')->nullable();
            $table->string('optional_subject')->nullable();
            $table->text('other_query')->nullable();
            $table->text('feedback')->nullable();
            $table->string('target_year', 4)->nullable();
            $table->string('enquiry_by')->nullable();
            $table->foreignId('marketer_id')->nullable()->constrained('marketers')->onDelete('set null');
            $table->foreignId('counselor_id')->nullable()->constrained('counselors')->onDelete('set null');
            $table->boolean('visited_class')->default(false);
            $table->boolean('demo_attended')->default(false);
            $table->foreignId('faculty_id')->nullable()->constrained('faculty')->onDelete('set null');
            $table->enum('status', ['New', 'Contacted', 'Interested', 'Not Interested', 'Enrolled'])->default('New');
            $table->enum('lead_category', ['Hot', 'Warm', 'Cold'])->nullable();
            $table->date('last_follow_up_date')->nullable();
            $table->date('next_follow_up_date')->nullable();
            $table->integer('follow_up_count')->default(0);
            $table->timestamps();

            $table->index('mobile_number', 'idx_mobile');
            $table->index('email', 'idx_email');
            $table->index('status', 'idx_status');
            $table->index(['counselor_id', 'status'], 'idx_counselor_status');
            $table->index('created_at', 'idx_created_at');
            $table->index('marketer_id', 'idx_marketer');
            $table->index('lead_category', 'idx_lead_category');
            $table->index(['counselor_id', 'lead_category'], 'idx_counselor_category');
            $table->index('next_follow_up_date', 'idx_next_follow_up');
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
