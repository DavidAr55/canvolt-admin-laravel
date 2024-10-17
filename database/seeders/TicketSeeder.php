<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use App\Models\Product;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generate 10 random dates for created_at and updated_at in this format "2024-10-03 18:55:47"
        $dates = collect(range(1, 10))->map(function() {
            return Carbon::now()->subDays(rand(1, 10))->format('Y-m-d H:i:s');
        });

        $folio_date = collect(range(1, 10))->map(function() {
            return Carbon::now()->subDays(rand(1, 5))->format('ymd');
        });

        // Get 10 random products with category_id 1, 2 and 3
        $products = Product::whereIn('category_id', [1, 2, 3])->inRandomOrder()->limit(6)->get();

        // Get 10 random services with category_id 4
        $services = Product::where('category_id', 4)->inRandomOrder()->limit(4)->get();

        // Get 10 random numbers for the total price
        $quantities = collect(range(1, 10))->map(function() {
            return rand(1, 5);
        });

        
        DB::table('tickets')->insert([
            [
                'folio' => "{$folio_date[0]}-0001",
                'country_code' => 'MX',
                'user_id' => 1,
                'branch_office_id' => 1,
                'status' => 'pending',
                'type' => json_encode(['product', 'service']),
                'ticket_details' => json_encode([
                    [
                        'product' => $products[0]->description_min,
                        'quantity' => $quantities[0],
                        'unit_price' => $products[0]->price,
                    ],
                    [
                        'service' => $services[0]->description_min,
                        'quantity' => $quantities[0],
                        'unit_price' => $services[0]->price,
                    ]
                ]),
                'total_price' => $products[0]->price * $quantities[0] + $services[0]->price * $quantities[0],
                'payment_method' => 'cash',
                'qr_code' => null,
                'created_at' => $dates[0],
                'updated_at' => $dates[0],
            ],
            [
                'folio' => "{$folio_date[1]}-0002",
                'country_code' => 'MX',
                'user_id' => 2,
                'branch_office_id' => 1,
                'status' => 'in_progress',
                'type' => json_encode(['service']),
                'ticket_details' => json_encode([
                    [
                        'service' => $services[1]->description_min,
                        'quantity' => $quantities[1],
                        'unit_price' => $services[1]->price,
                    ]
                ]),
                'total_price' => $services[1]->price * $quantities[1],
                'payment_method' => 'card',
                'qr_code' => null,
                'created_at' => $dates[1],
                'updated_at' => $dates[1],
            ],
            [
                'folio' => "{$folio_date[2]}-0003",
                'country_code' => 'MX',
                'user_id' => 3,
                'branch_office_id' => 1,
                'status' => 'finished',
                'type' => json_encode(['cotization']),
                'ticket_details' => json_encode([
                    [
                        'cotization' => $products[1]->description_min,
                        'quantity' => $quantities[2],
                        'unit_price' => $products[1]->price,
                    ],
                ]),
                'total_price' => $products[1]->price * $quantities[2],
                'payment_method' => 'cash',
                'qr_code' => "{$folio_date[3]}-0004",
                'created_at' => $dates[2],
                'updated_at' => $dates[2],
            ],
            [
                'folio' => "{$folio_date[3]}-0004",
                'country_code' => 'MX',
                'user_id' => 4,
                'branch_office_id' => 1,
                'status' => 'pending',
                'type' => json_encode(['service']),
                'ticket_details' => json_encode([
                    [
                        'service' => $services[2]->description_min,
                        'quantity' => $quantities[3],
                        'unit_price' => $services[2]->price,
                    ]
                ]),
                'total_price' => $services[2]->price * $quantities[3],
                'payment_method' => 'cash',
                'qr_code' => null,
                'created_at' => $dates[3],
                'updated_at' => $dates[3],
            ],
            [
                'folio' => "{$folio_date[4]}-0005",
                'country_code' => 'MX',
                'user_id' => 5,
                'branch_office_id' => 1,
                'status' => 'in_progress',
                'type' => json_encode(['product']),
                'ticket_details' => json_encode([
                    [
                        'product' => $products[2]->description_min,
                        'quantity' => $quantities[4],
                        'unit_price' => $products[2]->price,
                    ],
                ]),
                'total_price' => $products[2]->price * $quantities[4],
                'payment_method' => 'transfer',
                'qr_code' => null,
                'created_at' => $dates[4],
                'updated_at' => $dates[4],
            ],
            [
                'folio' => "{$folio_date[5]}-0006",
                'country_code' => 'MX',
                'user_id' => 6,
                'branch_office_id' => 1,
                'status' => 'finished',
                'type' => json_encode(['service']),
                'ticket_details' => json_encode([
                    [
                        'service' => $services[3]->description_min,
                        'quantity' => $quantities[5],
                        'unit_price' => $services[3]->price,
                    ]
                ]),
                'total_price' => $services[3]->price * $quantities[5],
                'payment_method' => 'cash',
                'qr_code' => "{$folio_date[5]}-0006",
                'created_at' => $dates[5],
                'updated_at' => $dates[5],
            ],
            [
                'folio' => "{$folio_date[6]}-0007",
                'country_code' => 'MX',
                'user_id' => 7,
                'branch_office_id' => 1,
                'status' => 'pending',
                'type' => json_encode(['cotization']),
                'ticket_details' => json_encode([
                    [
                        'cotization' => $products[0]->description_min,
                        'quantity' => $quantities[6],
                        'unit_price' => $products[0]->price,
                    ],
                ]),
                'total_price' => $products[0]->price * $quantities[6],
                'payment_method' => 'transfer',
                'qr_code' => null,
                'created_at' => $dates[6],
                'updated_at' => $dates[6],
            ],
            [
                'folio' => "{$folio_date[7]}-0008",
                'country_code' => 'US',
                'user_id' => 8,
                'branch_office_id' => 1,
                'status' => 'in_progress',
                'type' => json_encode(['product']),
                'ticket_details' => json_encode([
                    [
                        'product' => $products[4]->description_min,
                        'quantity' => $quantities[7],
                        'unit_price' => $products[4]->price,
                    ],
                ]),
                'total_price' => $products[4]->price * $quantities[7],
                'payment_method' => 'cash',
                'qr_code' => null,
                'created_at' => $dates[7],
                'updated_at' => $dates[7],
            ],
            [
                'folio' => "{$folio_date[8]}-0009",
                'country_code' => 'MX',
                'user_id' => 9,
                'branch_office_id' => 1,
                'status' => 'finished',
                'type' => json_encode(['service']),
                'ticket_details' => json_encode([
                    [
                        'service' => $services[1]->description_min,
                        'quantity' => $quantities[8],
                        'unit_price' => $services[1]->price,
                    ]
                ]),
                'total_price' => $services[1]->price * $quantities[8],
                'payment_method' => 'cash',
                'qr_code' => "{$folio_date[8]}-0009",
                'created_at' => $dates[8],
                'updated_at' => $dates[8],
            ],
            [
                'folio' => "{$folio_date[9]}-0010",
                'country_code' => 'US',
                'user_id' => 10,
                'branch_office_id' => 1,
                'status' => 'pending',
                'type' => json_encode(['cotization']),
                'ticket_details' => json_encode([
                    [
                        'cotization' => $products[5]->description_min,
                        'quantity' => $quantities[9],
                        'unit_price' => $products[5]->price,
                    ],
                ]),
                'total_price' => $products[5]->price * $quantities[9],
                'payment_method' => 'cash',
                'qr_code' => null,
                'created_at' => $dates[9],
                'updated_at' => $dates[9],
            ],
        ]);
    }
}
