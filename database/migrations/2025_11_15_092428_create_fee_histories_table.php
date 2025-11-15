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
        Schema::create('fee_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fee_id');
            $table->decimal('amount',12,2);
            $table->enum('type',['collect','refund'])->default('collect');
            $table->string('note')->nullable();
            $table->timestamps();

            $table->foreign('fee_id')->references('id')->on('fees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_histories');
    }
};
