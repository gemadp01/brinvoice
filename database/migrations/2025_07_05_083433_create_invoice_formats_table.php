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
        Schema::create('invoice_formats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sender_title')->default('DITERBITKAN ATAS NAMA');
            $table->string('sender_label')->default('Penjual');
            $table->string('receiver_title')->default('UNTUK');
            $table->string('receiver_label')->default('Pembeli');
            $table->string('invoice_date_label')->default('Tanggal Pembelian');
            $table->string('invoice_address_label')->default('Alamat Pengiriman');
            $table->string('item_label')->default('INFO PRODUK');
            $table->string('quantity_label')->default('JUMLAH');
            $table->string('price_label')->default('HARGA SATUAN');
            $table->string('price_total_label')->default('TOTAL HARGA');
            $table->string('subtotal_label')->default('SUBTOTAL HARGA BARANG');
            $table->string('discount_label')->default('Diskon')->nullable();
            $table->string('shipment_label')->default('Ongkos Kirim')->nullable();
            $table->string('tax_label')->default('Biaya Pajak')->nullable();
            $table->string('service_label')->default('Biaya Pelayanan')->nullable();
            $table->string('bill_total_label')->default('TOTAL TAGIHAN');
            $table->string('payment_method_label')->default('Metode Pembayaran');
            $table->string('payment_method_name')->default('BRI Virtual Account');
            $table->string('payment_method_number')->default('000-0000-0000');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_formats');
    }
};
