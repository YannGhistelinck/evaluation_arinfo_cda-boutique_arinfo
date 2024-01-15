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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->boolean('productStatus')->default(0);
            $table->string('productName');
            $table->text('productDescription');
            $table->float('price');
            $table->integer('stock');
            $table->timestamps();

            $table->foreignId('category_id')->nullable()->default(null)->constrained();
            $table->foreignId('sub_category_id')->nullable()->default(null)->constrained();
            $table->foreignId('promotion_id')->nullable()->constrained();
            $table->foreignId('size_id')->constrained()->default(1);
            $table->foreignId('collection_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
