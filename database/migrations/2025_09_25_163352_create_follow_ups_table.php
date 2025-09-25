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
            $table->foreignId('lead_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Who made the follow-up
            
            // Follow-up Details
            $table->enum('type', [
                'Phone Call',
                'Email',
                'SMS',
                'WhatsApp',
                'In-Person Meeting',
                'Video Call',
                'Demo Class',
                'Other'
            ]);
            $table->enum('status', ['Scheduled', 'Completed', 'Cancelled', 'No Response']);
            $table->datetime('scheduled_at');
            $table->datetime('completed_at')->nullable();
            
            // Communication Details
            $table->text('notes'); // What was discussed
            $table->text('outcome')->nullable(); // Result of the follow-up
            $table->enum('interest_level', ['Very High', 'High', 'Medium', 'Low', 'Not Interested'])->nullable();
            
            // Next Action
            $table->datetime('next_follow_up_date')->nullable();
            $table->text('next_action')->nullable();
            
            // Attachments/Documents
            $table->json('attachments')->nullable(); // Store file paths if any documents shared
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['lead_id', 'scheduled_at']);
            $table->index(['user_id', 'scheduled_at']);
            $table->index(['status', 'scheduled_at']);
            $table->index(['next_follow_up_date']);
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