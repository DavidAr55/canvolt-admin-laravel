<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; 

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('cost', 8, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert default shipping methods
        DB::table('shipping_methods')->insert([
            [
                'name' => 'Solo Zona Metropolitana de Guadalajara - Envío Local',
                'cost' => 89.00,
                'is_active' => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name' => 'Paquetería: Estafeta',
                'cost' => 186.00,
                'is_active' => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name' => 'Paquetería: FedEx',
                'cost' => 209.00,
                'is_active' => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name' => 'Paquetería: Paquete E.',
                'cost' => 209.00,
                'is_active' => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_methods');
    }
};
