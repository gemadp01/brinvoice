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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('invoice_format_id')->constrained('invoice_formats')->cascadeOnDelete();
            $table->string('invoice_code')->unique();
            $table->string('receiver');
            $table->string('receiver_email');
            $table->date('invoice_date');
            $table->string('invoice_address');
            $table->integer('subtotal');
            $table->integer('discount')->default(0);
            $table->integer('shipment')->default(0);
            $table->integer('tax')->default(0);
            $table->integer('service')->default(0);
            $table->integer('bill_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
