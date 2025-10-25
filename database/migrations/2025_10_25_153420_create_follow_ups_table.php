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
        Schema::create('follow_ups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            $table->foreignId('counselor_id')->constrained('counselors')->onDelete('cascade');
            $table->date('follow_up_date');
            $table->time('follow_up_time')->nullable();
            $table->enum('status', ['Pending', 'Completed', 'Missed', 'Rescheduled'])->default('Pending');
            $table->enum('contact_method', ['Phone', 'Email', 'WhatsApp', 'In-Person', 'Other'])->default('Phone');
            $table->text('notes')->nullable();
            $table->enum('outcome', ['Interested', 'Not Interested', 'Call Back Later', 'No Response', 'Enrolled', 'Other'])->nullable();
            $table->date('next_follow_up_date')->nullable();
            $table->enum('priority', ['High', 'Medium', 'Low'])->default('Medium');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index('lead_id', 'idx_lead_id');
            $table->index('counselor_id', 'idx_counselor_id');
            $table->index('follow_up_date', 'idx_follow_up_date');
            $table->index('status', 'idx_status');
            $table->index(['lead_id', 'counselor_id'], 'idx_lead_counselor');
            $table->index(['priority', 'follow_up_date'], 'idx_priority_date');
            $table->index(['status', 'follow_up_date'], 'idx_status_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follow_ups');
    }
};
