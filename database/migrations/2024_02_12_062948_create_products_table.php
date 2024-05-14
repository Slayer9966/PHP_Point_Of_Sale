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
            
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('Name');
            $table->integer('Quantity')->nullable()->unsigned();
            $table->integer('Price')->nullable()->unsigned();
            $table->integer('SalePrice')->nullable()->unsigned();
            $table->unsignedBigInteger('Product_Code')->unique()->default(0);
            $table->string('ProductImage')->nullable();
            $table->timestamps();
           
            
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
