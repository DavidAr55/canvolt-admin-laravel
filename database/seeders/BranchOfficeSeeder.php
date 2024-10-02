<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchOfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('branch_offices')->insert([
            'name' => 'Canvolt Zapopan Centro',
            'address' => 'C. Juan Manuel 304, Zapopan, 45100 Zapopan, Jal.',
            'phone' => '33 3258 8070',
            'email' => 'contacto@canvolt.com.mx',
            'image' => 'branch_offices/canvolt-zapopan-centro.png',
            'status' => 'active',
            'schedule' => 'Lunes a Sábado de 10:30 a 20:30 hrs',
            'latitude' => 20.723508,
            'longitude' => -103.3878972
        ]);
    }
}
