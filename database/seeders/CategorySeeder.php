<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Scooters',
                'description' => 'Scooters eléctricos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Piezas',
                'description' => 'Piezas para scooters eléctricos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Accesorios',
                'description' => 'Accesorios para tí o para tu scooter eléctrico',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Servicios',
                'description' => 'Servicios de instalación y mantenimiento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
