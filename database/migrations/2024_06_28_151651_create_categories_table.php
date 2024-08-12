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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
        
        // Insert default roles
        DB::table('categories')->insert([
            [
                'name'        => 'Scooters',
                'description' => 'Scooters eléctricos',
                'created_at'  => now(),
                'updated_at'  => now()
            ],
            [
                'name'        => 'Piezas',
                'description' => 'Piezas para scooters',
                'created_at'  => now(),
                'updated_at'  => now()
            ],
            [
                'name'        => 'Accesorios',
                'description' => 'Accesorios para tí o para tu scooter',
                'created_at'  => now(),
                'updated_at'  => now()
            ],
            [
                'name'        => 'Servicios',
                'description' => 'Servicios de instalación y mantenimiento',
                'created_at'  => now(),
                'updated_at'  => now()
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
