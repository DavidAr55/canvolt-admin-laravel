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
            [
                'name' => 'Canvolt Zapopan Centro',
                'address' => 'C. Juan Manuel 304, Zapopan, 45100 Zapopan, Jal.',
                'phone' => '33 3258 8070',
                'email' => 'zapopan@canvolt.com.mx',
                'image' => 'branch_offices/canvolt-zapopan-centro.png',
                'status' => 'active',
                'schedule' => 'Lunes a Sábado de 10:30 a 20:30 hrs',
                'latitude' => 20.723508,
                'longitude' => -103.3878972
            ],
            [
                'name' => 'Canvolt Punto Sur',
                'address' => 'Anillo Perif. Sur Manuel Gómez Morín 8585, Santa María Tequepexpan, 45604 San Pedro Tlaquepaque, Jal.',
                'phone' => '+523336693434',
                'email' => 'punto-sur@canvolt.com.mx',
                'image' => 'branch_offices/canvolt-punto-sur.png',
                'status' => 'inactive',
                'schedule' => 'Lunes a Sábado de 10:30 a 20:30 hrs',
                'latitude' => 20.6103765,
                'longitude' => -103.4137433
            ],
        ]);
    }
}
