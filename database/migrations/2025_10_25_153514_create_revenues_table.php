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
        Schema::create('revenues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('counselor_id')->constrained('counselors');
            $table->foreignId('lead_id')->nullable()->constrained('leads')->onDelete('set null');
            $table->date('date');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_mode', ['Cash', 'UPI', 'Card', 'Net Banking', 'Cheque', 'Other'])->default('Cash');
            $table->string('transaction_id')->nullable();
            $table->string('receipt_number')->nullable();
            $table->string('course_type')->nullable();
            $table->enum('payment_type', ['Registration Fee', 'Course Fee', 'Installment', 'Material Fee', 'Exam Fee', 'Other'])->default('Course Fee');
            $table->integer('installment_number')->nullable();
            $table->integer('total_installments')->nullable();
            $table->decimal('discount_applied', 10, 2)->default(0.00);
            $table->text('notes')->nullable();
            $table->enum('status', ['Pending', 'Confirmed', 'Cancelled', 'Refunded'])->default('Confirmed');
            $table->foreignId('collected_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            $table->index('counselor_id', 'idx_counselor_id');
            $table->index('lead_id', 'idx_lead_id');
            $table->index('date', 'idx_date');
            $table->index('status', 'idx_status');
            $table->index('payment_type', 'idx_payment_type');
            $table->index('collected_by', 'idx_collected_by');
            $table->index('verified_by', 'idx_verified_by');
            $table->index(['counselor_id', 'date'], 'idx_counselor_date');
            $table->index('receipt_number', 'idx_receipt_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revenues');
    }
};
