<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
}
