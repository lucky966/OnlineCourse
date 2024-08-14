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
        Schema::create('subcribe_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('total_amount');
            $table->boolean('is_paid');
            $table->string('proof');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('subcription_start_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subcribe_transactions');
    }
};
