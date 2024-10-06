<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                [
                    'category_id' => 1,
                    'code' => 'scooter-monorim-7e5965678e7973a7',
                    'brand' => 'Monorim',
                    'name' => 'Suv S1',
                    'description' => 'El scooter Monorim SUV S1 es una opción ideal para quienes buscan un vehículo eléctrico con gran potencia y versatilidad. Equipado con un motor de 500W en cada rueda, este scooter puede alcanzar una velocidad máxima de 65 km/h en áreas privadas y ofrece una autonomía de hasta 50 km con una sola carga. Además, dispone de un sistema de suspensión doble, estabilizador de dirección, intermitentes y una plataforma iluminada, emite un sonido similar al de una moto al acelerar, y cuenta con neumáticos antipinchazos para que nunca te quedes varado.',
                    'description_min' => '48v 20Ah, dual 1000w, velocidad máxima 60km/h',
                    'price' => 32999.00,
                    'discount' => 0,
                    'condition' => 'new',
                    'type' => 'product',
                    'photo_main' => 'product_photos/PxVkjdE31FGS0bPA7rjZszfC0VHS7vrWCFnWBqXp.png',
                    'photos' => json_encode([
                        'product_photos/idDRhGkDHUvglO42S3C2qsiRntKBGFFfhfz9jWza.png',
                        'product_photos/tiWNrRt1n1XycOb8dSZnWuJCw4qzNMmR2QYPhyXl.png',
                        'product_photos/9HVgIM5P9BhuS4LBUhyOA7w0Jk3xE3R3aXTcDW9h.png',
                        'product_photos/LfcT2OkMqcIcTykSAecDp28oVy20KN8h354G46vy.png'
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ], 
                [
                    'category_id' => 1,
                    'code' => 'scooter-xiaomi-f7de35e174c41ea2',
                    'brand' => 'Xiaomi',
                    'name' => 'T0s',
                    'description' => 'El T0S es un scooter diseñado para resistir el uso diario. A pesar de ser el modelo más asequible de la marca, está equipado con una batería de 7.8Ah a 36V, capaz de recorrer hasta 25 km con una sola carga. Tiene un sistema de plegado reforzado con doble vástago y un mecanismo de plegado mejorado. En términos de comodidad, como todos nuestros modelos, incluye el kit de 10 pulgadas, en este caso con neumáticos de aire y la suspensión delantera MONORIM©, asegurando trayectos más suaves.',
                    'description_min' => 'T0S / 36V / 7,8Ah',
                    'price' => 17499.00,
                    'discount' => 20,
                    'condition' => 'new',
                    'type' => 'product',
                    'photo_main' => 'product_photos/WxviFuCPE8x0CeChO38cEO0Wr8GoQN9MKfTW5ppN.png',
                    'photos' => json_encode([
                        'product_photos/ctv3FhaVNFCBRxLfJaz6hv0R7JSK4h9828YxsLVE.png',
                        'product_photos/ELLNrg5IbKt2TvwMdvQ24Hb3DGxUDlMA0tliwOH2.png',
                        'product_photos/Er1tWeg5U3Z5kVRHkbLUDv4DJyN1rQ7x3wnWT7AU.png',
                        'product_photos/teCW1dJiMQ9poNI8cIysx5xSAcGHr8SBQkDtvm3b.png'
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'category_id' => 1,
                    'code' => 'scooter-xiaomi-6aa1a95bfddfc57e',
                    'brand' => 'Xiaomi',
                    'name' => 'T3S',
                    'description' => 'El Scooter Eléctrico Monorim T3S está equipado con suspensión delantera y un motor de 380W. Aprovechamos la robustez del chasis del Ninebot G30 para ofrecer una mayor solidez y seguridad. En términos de comodidad, incluye neumáticos antipinchazos de 10 pulgadas y suspensión delantera, lo que proporciona una mayor seguridad en la conducción al evitar cualquier irregularidad del terreno.',
                    'description_min' => 'Eco mode 15mk/h – modo normal 20km/h – modo sport 30km/h',
                    'price' => 22499.00,
                    'discount' => 20,
                    'condition' => 'new',
                    'type' => 'product',
                    'photo_main' => 'product_photos/gW9ppY9BOCXvyLAcgEXRfUMNaXoRultOySkbVF9o.png',
                    'photos' => json_encode([
                        'product_photos/YlZ6RWQxIerCurrsLmQ83Q9f8iWU1VuunQpLzNeU.png',
                        'product_photos/DnWyD3u4RO104ZhUTWjudNT4spI1YbBEcOjjoGjw.png',
                        'product_photos/FUcd4Y0veBLCKqjSSRJXIf6dgMohU3lLJ8PvmEwI.png'
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'category_id' => 1,
                    'code' => 'scooter-xiaomi-6e0d6249be766cde',
                    'brand' => 'Xiaomi',
                    'name' => 'T2S Pro',
                    'description' => 'El Scooter Eléctrico Monorim TS2 es un modelo discreto que viene de fábrica con un kit de 10 pulgadas y neumáticos antipinchazos. Cuenta con un motor de 500W, lo que le permite subir pendientes de hasta 25 grados, aprovechando su batería de 48V que lo hace muy versátil. Además, le añadimos suspensión delantera y un mástil reforzado con un sistema de plegado mejorado, lo que disminuye considerablemente las holguras típicas de los modelos convencionales de Xiaomi.',
                    'description_min' => 'Eco mode 15mk/h – modo normal 20km/h – modo sport 50km/h',
                    'price' => 19499.00,
                    'discount' => 20,
                    'condition' => 'new',
                    'type' => 'product',
                    'photo_main' => 'product_photos/B9kvtOSINOxBa8Hwd7rKyctoGfZPhqouwvVuRcMt.png',
                    'photos' => json_encode([
                        'product_photos/e7mukRXtERXSv6nWiQ6m8nw98cKVrioyyveT0DvJ.png',
                        'product_photos/bRAZh2FQ9QPdTNXmlixghavXyaxuJrKQW5nGZDxH.png',
                        'product_photos/dIOUGvDbqF9evFvSux1V2DhuvshlstYgnaUIm254.png'
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'category_id' => 2,
                    'code' => 'pieza-honey-whale-d9f3dd392e53ebaa',
                    'brand' => 'Honey Whale',
                    'name' => 'Llanta Sólida 10 pulgadas x 2.75',
                    'description' => 'Neumático sólido 10x2,75-6,5 para scooter eléctrico de 10 pulgadas, a prueba de pinchazos, accesorios de neumáticos todoterreno sin necesidad de inflado.\r\n\r\nEste neumático mide 10x2,75-6,5. Su diseño hueco ofrece un mejor efecto de absorción de impactos y puede reemplazar neumáticos de 10x2,70-6,5, 255x70, 10x2,50-6,5 y otros modelos.',
                    'description_min' => 'Neumático sólido de 10x2,75-6,5',
                    'price' => 690.00,
                    'discount' => 20,
                    'condition' => 'new',
                    'type' => 'product',
                    'photo_main' => 'product_photos/URXziqMEUtiwNsFPKpK3Kq77oBFrx9ntUHQqn8WQ.png',
                    'photos' => json_encode([
                        'product_photos/hJ0bgAA2Eze00zhk6oltW2j3jLrbKU1Mt1A5OwZH.png',
                        'product_photos/OLuE0sjVd73jHVgMspeA1STP9agVuAaf1R3y2MXN.png',
                        'product_photos/wabutASqmzD4xmJO0Kqq2bZSbIOHjZXNIwGKjlxH.png'
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'category_id' => 4,
                    'code' => null,
                    'brand' => 'Honey Whale',
                    'name' => 'Llanta Sólida 10 pulgadas x 2.75 (Instalación)',
                    'description' => 'Neumático sólido 10x2,75-6,5 para scooter eléctrico de 10 pulgadas, a prueba de pinchazos, accesorios de neumáticos todoterreno sin necesidad de inflado.\r\n\r\nEste neumático mide 10x2,75-6,5. Su diseño hueco ofrece un mejor efecto de absorción de impactos y puede reemplazar neumáticos de 10x2,70-6,5, 255x70, 10x2,50-6,5 y otros modelos.',
                    'description_min' => 'Neumático sólido de 10x2,75-6,5',
                    'price' => 1040.00,
                    'discount' => 20,
                    'condition' => 'new',
                    'type' => 'service',
                    'photo_main' => 'product_photos/wabutASqmzD4xmJO0Kqq2bZSbIOHjZXNIwGKjlxH.png',
                    'photos' => json_encode([
                        'product_photos/hJ0bgAA2Eze00zhk6oltW2j3jLrbKU1Mt1A5OwZH.png',
                        'product_photos/OLuE0sjVd73jHVgMspeA1STP9agVuAaf1R3y2MXN.png',
                        'product_photos/wabutASqmzD4xmJO0Kqq2bZSbIOHjZXNIwGKjlxH.png'
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ],
        ]);
    }
}
