<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('sales_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_id');
            $table->foreignId('products_id');
            $table->decimal('price', 11, 2);
            $table->integer('amount');
            $table->decimal('iva', 11, 2);
            $table->decimal('subtotal', 11, 2);
            $table->decimal('total', 11, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('sales_products');
    }
};
