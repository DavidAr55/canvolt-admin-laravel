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
                'map_url' => 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14926.691131034255!2d-103.3878972!3d20.723508!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8428af439abdd64b%3A0x56a17e43e65f18b!2sCanvolt!5e0!3m2!1ses!2smx!4v1729631346491!5m2!1ses!2smx',
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
                'map_url' => 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14938.008555899309!2d-103.4146601!3d20.6083796!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8428ad6363a15d99%3A0x35dfe443ec2fc6c6!2sITESO%2C%20Universidad%20Jesuita%20de%20Guadalajara!5e0!3m2!1ses!2smx!4v1729631428357!5m2!1ses!2smx',
                'image' => 'branch_offices/canvolt-punto-sur.png',
                'status' => 'inactive',
                'schedule' => 'Lunes a Sábado de 10:30 a 20:30 hrs',
                'latitude' => 20.6103765,
                'longitude' => -103.4137433
            ],
        ]);
    }
}
