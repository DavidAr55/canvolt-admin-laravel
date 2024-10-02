<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = now()->format('ymd');
        
        DB::table('tickets')->insert([
            [
                'folio' => "$date-0001",
                'user_id' => 1,
                'branch_office_id' => 1,
                'status' => 'pending',
                'type' => 'sale',
                'ticket_details' => json_encode([
                    [
                        'product' => 'Scooter X500',
                        'quantity' => 1,
                        'unit_price' => 1000,
                    ]
                ]),
                'acknowledgments_message' => 'Gracias por su compra, procesaremos su pedido.',
                'total_price' => '1000',
                'qr_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'folio' => "$date-0002",
                'user_id' => 2,
                'branch_office_id' => 1,
                'status' => 'in_progress',
                'type' => 'service',
                'ticket_details' => json_encode([
                    [
                        'product' => 'Reparación de frenos',
                        'quantity' => 1,
                        'unit_price' => 200,
                    ]
                ]),
                'acknowledgments_message' => 'Reparación en curso, lo notificaremos al finalizar.',
                'total_price' => '200',
                'qr_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'folio' => "$date-0003",
                'user_id' => 3,
                'branch_office_id' => 1,
                'status' => 'finished',
                'type' => 'cotization',
                'ticket_details' => json_encode([
                    [
                        'product' => 'Scooter Z200',
                        'quantity' => 1,
                        'unit_price' => 800,
                    ]
                ]),
                'acknowledgments_message' => 'Cotización enviada, en espera de su confirmación.',
                'total_price' => '800',
                'qr_code' => "$date-0001",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'folio' => "$date-0004",
                'user_id' => 4,
                'branch_office_id' => 1,
                'status' => 'pending',
                'type' => 'service',
                'ticket_details' => json_encode([
                    [
                        'product' => 'Diagnóstico de batería',
                        'quantity' => 1,
                        'unit_price' => 150,
                    ]
                ]),
                'acknowledgments_message' => 'Diagnóstico en cola, lo atenderemos pronto.',
                'total_price' => '150',
                'qr_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'folio' => "$date-0005",
                'user_id' => 5,
                'branch_office_id' => 1,
                'status' => 'in_progress',
                'type' => 'sale',
                'ticket_details' => json_encode([
                    [
                        'product' => 'Scooter Y900',
                        'quantity' => 1,
                        'unit_price' => 1200,
                    ]
                ]),
                'acknowledgments_message' => 'Procesando su compra.',
                'total_price' => '1200',
                'qr_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'folio' => "$date-0006",
                'user_id' => 6,
                'branch_office_id' => 1,
                'status' => 'finished',
                'type' => 'service',
                'ticket_details' => json_encode([
                    [
                        'product' => 'Cambio de llantas',
                        'quantity' => 2,
                        'unit_price' => 150,
                    ]
                ]),
                'acknowledgments_message' => 'Servicio completado, puede pasar a recoger su scooter.',
                'total_price' => '300',
                'qr_code' => "$date-0007",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'folio' => "$date-0001",
                'user_id' => 7,
                'branch_office_id' => 1,
                'status' => 'pending',
                'type' => 'cotization',
                'ticket_details' => json_encode([
                    [
                        'product' => 'Scooter Z500',
                        'quantity' => 1,
                        'unit_price' => 900,
                    ]
                ]),
                'acknowledgments_message' => 'Cotización pendiente de aprobación.',
                'total_price' => '900',
                'qr_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'folio' => "$date-0008",
                'user_id' => 8,
                'branch_office_id' => 1,
                'status' => 'in_progress',
                'type' => 'sale',
                'ticket_details' => json_encode([
                    [
                        'product' => 'Scooter V200',
                        'quantity' => 2,
                        'unit_price' => 1500,
                    ]
                ]),
                'acknowledgments_message' => 'Su pedido está siendo preparado.',
                'total_price' => '3000',
                'qr_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'folio' => "$date-0009",
                'user_id' => 9,
                'branch_office_id' => 1,
                'status' => 'finished',
                'type' => 'service',
                'ticket_details' => json_encode([
                    [
                        'product' => 'Revisión general',
                        'quantity' => 1,
                        'unit_price' => 400,
                    ]
                ]),
                'acknowledgments_message' => 'Servicio completado, pase a la sucursal para más detalles.',
                'total_price' => '400',
                'qr_code' => "$date-0001",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'folio' => "$date-0010",
                'user_id' => 10,
                'branch_office_id' => 1,
                'status' => 'pending',
                'type' => 'cotization',
                'ticket_details' => json_encode([
                    [
                        'product' => 'Scooter X1000',
                        'quantity' => 1,
                        'unit_price' => 2500,
                    ]
                ]),
                'acknowledgments_message' => 'Cotización pendiente, lo contactaremos pronto.',
                'total_price' => '2500',
                'qr_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
