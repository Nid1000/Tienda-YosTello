<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('customer_first_name');
            $table->string('customer_last_name');
            $table->string('document_type', 10);
            $table->string('document_number', 20);
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->text('shipping_address');
            $table->string('shipping_reference')->nullable();
            $table->string('delivery_method')->default('domicilio');
            $table->string('department');
            $table->string('province');
            $table->string('district');
            $table->string('payment_method');
            $table->string('status')->default('pendiente');
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
