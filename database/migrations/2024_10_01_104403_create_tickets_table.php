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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('folio');
            $table->string('country_code');
            
            // Foreign key to users table
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Foreign key to branch_offices table
            $table->unsignedBigInteger('branch_office_id');
            $table->foreign('branch_office_id')->references('id')->on('branch_offices')->onDelete('cascade');

            $table->enum('status', ['pending', 'in_progress', 'finished']);
            $table->json('type');
            $table->json('ticket_details');
            $table->string('details')->nullable();
            $table->string('extra_discount')->nullable();
            $table->string('total_price');
            $table->enum('payment_method', ['cash', 'card', 'transfer', 'other']);
            $table->string('qr_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
