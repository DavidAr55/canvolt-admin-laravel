<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BranchOfficeSeeder::class,
            AdminSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            // ProductSeeder::class,
            AddressSeeder::class,
            ShippingMethodSeeder::class,
            // TicketSeeder::class,
        ]);
    }
}
