<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('addresses')->insert([
            'user_id' => 17,
            'token' => Str::random(36),
            'street' => 'Fresno',
            'external_number' => '173',
            'neighborhood' => 'Lomas del camichin',
            'city' => 'Tonala',
            'state' => 'JALISCO',
            'postal_code' => '45403',
            'country' => 'México',
            'reference' => 'A un costado del Conalep Tonala',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
