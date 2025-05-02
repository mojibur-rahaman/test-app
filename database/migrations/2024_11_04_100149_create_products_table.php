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
            $table->string('name');
            $table->string('en_name');
            $table->string('slug')->unique();
            $table->integer('price');
            $table->integer('weight');
            $table->string('weightDesc');
            $table->string('category')->nullable();
            $table->integer('maxQuantity');
            
            $table->string('metaTitle');
            $table->text('metaKeyword');
            $table->mediumText('metaDescription');

            $table->mediumText('sortDesc')->nullable();
            $table->longText('longDesc')->nullable();

            $table->tinyInteger('status')->default(0);

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
