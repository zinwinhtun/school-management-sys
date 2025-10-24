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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');
            $table->unsignedBigInteger('class_id')->nullable();
            $table->decimal('purchase_price', 12, 2);
            $table->decimal('sell_price', 12, 2);
            $table->integer('stock');
            $table->timestamps();

            $table->foreign('class_id')->references('id')->on('class_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
