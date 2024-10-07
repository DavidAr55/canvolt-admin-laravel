<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Hector Gonzalez',
                'email' => 'hector@gmail.com',
                'contact' => [
                    'email' => 'hector@gmail.com',
                    'phone' => '+52 33 3258 8070'
                ],
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'admin_id' => null,
                'remember_token' => null,
                'external_id' => 'JDAIS8U7D9832FAW321',
                'external_auth' => 'Google',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'María Pérez',
                'email' => 'maria.perez@example.com',
                'contact' => [
                    'email' => 'maria.perez@example.com',
                    'phone' => '+52 33 3258 8070'
                ],
                'email_verified_at' => now(),
                'password' => Hash::make('87654321'),
                'admin_id' => null,
                'remember_token' => Str::random(10),
                'external_id' => 'PQR4567XYZ',
                'external_auth' => 'Facebook',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Juan Martínez',
                'email' => 'juan.martinez@example.com',
                'contact' => [
                    'email' => 'juan.martinez@example.com',
                    'phone' => '+52 33 3258 8070'
                ],
                'email_verified_at' => now(),
                'password' => Hash::make('mypassword'),
                'admin_id' => null,
                'remember_token' => Str::random(10),
                'external_id' => 'XYZ7890ABC',
                'external_auth' => 'LinkedIn',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lucía Torres',
                'email' => 'lucia.torres@example.com',
                'contact' => [
                    'email' => 'lucia.torres@example.com',
                    'phone' => '+52 33 3258 8070'
                ],
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'admin_id' => null,
                'remember_token' => Str::random(10),
                'external_id' => null,
                'external_auth' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Carlos Jiménez',
                'email' => 'carlos.jimenez@example.com',
                'contact' => [
                    'email' => 'carlos.jimenez@example.com',
                    'phone' => '+52 33 3258 8070'
                ],
                'email_verified_at' => now(),
                'password' => Hash::make('securepass'),
                'admin_id' => null,
                'remember_token' => Str::random(10),
                'external_id' => 'LMN12345OPQ',
                'external_auth' => 'Twitter',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sofía González',
                'email' => 'sofia.gonzalez@example.com',
                'contact' => [
                    'email' => 'sofia.gonzalez@example.com',
                    'phone' => '+52 33 3258 8070'
                ],
                'email_verified_at' => now(),
                'password' => Hash::make('mypassword1'),
                'admin_id' => null,
                'remember_token' => Str::random(10),
                'external_id' => 'ABC98765XYZ',
                'external_auth' => 'Google',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Diego Rivera',
                'email' => 'diego.rivera@example.com',
                'contact' => [
                    'email' => 'diego.rivera@example.com',
                    'phone' => '+52 33 3258 8070'
                ],
                'email_verified_at' => now(),
                'password' => Hash::make('password456'),
                'admin_id' => null,
                'remember_token' => Str::random(10),
                'external_id' => null,
                'external_auth' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Valentina Cruz',
                'email' => 'valentina.cruz@example.com',
                'contact' => [
                    'email' => 'valentina.cruz@example.com',
                    'phone' => '+52 33 3258 8070'
                ],
                'email_verified_at' => now(),
                'password' => Hash::make('valentina123'),
                'admin_id' => null,
                'remember_token' => Str::random(10),
                'external_id' => 'DEF12345GHI',
                'external_auth' => 'Facebook',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Luis Fernández',
                'email' => 'luis.fernandez@example.com',
                'contact' => [
                    'email' => 'luis.fernandez@example.com',
                    'phone' => '+52 33 3258 8070'
                ],
                'email_verified_at' => now(),
                'password' => Hash::make('luisfernandez'),
                'admin_id' => null,
                'remember_token' => Str::random(10),
                'external_id' => null,
                'external_auth' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Angela Ruiz',
                'email' => 'angela.ruiz@example.com',
                'contact' => [
                    'email' => 'angela.ruiz@example.com',
                    'phone' => '+52 33 3258 8070'
                ],
                'email_verified_at' => now(),
                'password' => Hash::make('angela123'),
                'admin_id' => null,
                'remember_token' => Str::random(10),
                'external_id' => 'GHI67890JKL',
                'external_auth' => 'LinkedIn',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fernando Torres',
                'email' => 'fernando.torres@example.com',
                'contact' => [
                    'email' => 'fernando.torres@example.com',
                    'phone' => '+52 33 3258 8070'
                ],
                'email_verified_at' => now(),
                'password' => Hash::make('ferndando456'),
                'admin_id' => null,
                'remember_token' => Str::random(10),
                'external_id' => null,
                'external_auth' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Claudia Ríos',
                'email' => 'claudia.rios@example.com',
                'contact' => [
                    'email' => 'claudia.rios@example.com',
                    'phone' => null
                ],
                'email_verified_at' => now(),
                'password' => Hash::make('claudia789'),
                'admin_id' => null,
                'remember_token' => Str::random(10),
                'external_id' => 'JKL12345MNO',
                'external_auth' => 'Twitter',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pablo Salazar',
                'email' => 'pablo.salazar@example.com',
                'contact' => [
                    'email' => 'pablo.salazar@example.com',
                    'phone' => null
                ],
                'email_verified_at' => now(),
                'password' => Hash::make('pablo1234'),
                'admin_id' => null,
                'remember_token' => Str::random(10),
                'external_id' => null,
                'external_auth' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Isabel Morales',
                'email' => 'isabel.morales@example.com',
                'contact' => [
                    'email' => 'isabel.morales@example.com',
                    'phone' => null
                ],
                'email_verified_at' => now(),
                'password' => Hash::make('isabel2024'),
                'admin_id' => null,
                'remember_token' => Str::random(10),
                'external_id' => 'MNO45678PQR',
                'external_auth' => 'Google',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ricardo López',
                'email' => 'ricardo.lopez@example.com',
                'contact' => [
                    'email' => 'ricardo.lopez@example.com',
                    'phone' => '+52 33 3258 8070'
                ],
                'email_verified_at' => now(),
                'password' => Hash::make('ricardo2023'),
                'admin_id' => null,
                'remember_token' => Str::random(10),
                'external_id' => null,
                'external_auth' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // Insert 2 admin users
                'name' => 'Marco Perez',
                'email' => 'marco@canvolt.com.mx',
                'contact' => [
                    'email' => 'marco@canvolt.com.mx',
                    'phone' => '+52 33 3258 8070'
                ],
                'email_verified_at' => now(),
                'password' => Hash::make('Canvolt2024!'),
                'admin_id' => 1,
                'remember_token' => null,
                'external_id' => null,
                'external_auth' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'David Loera',
                'email' => 'david@canvolt.com.mx',
                'contact' => [
                    'email' => 'david@canvolt.com.mx',
                    'phone' => '+52 33 3258 8070'
                ],
                'email_verified_at' => now(),
                'password' => Hash::make('Canvolt2024!'),
                'admin_id' => 2,
                'remember_token' => null,
                'external_id' => null,
                'external_auth' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
