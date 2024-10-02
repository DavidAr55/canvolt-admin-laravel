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
                /*
                (3, 1, 'scooter-xiaomi-6aa1a95bfddfc57e', 'Xiaomi', 'T3S', 'El Scooter Eléctrico Monorim T3S está equipado con suspensión delantera y un motor de 380W. Aprovechamos la robustez del chasis del Ninebot G30 para ofrecer una mayor solidez y seguridad. En términos de comodidad, incluye neumáticos antipinchazos de 10 pulgadas y suspensión delantera, lo que proporciona una mayor seguridad en la conducción al evitar cualquier irregularidad del terreno.', 'Eco mode 15mk/h – modo normal 20km/h – modo sport 30km/h', '22499.00', 5, 'new', 'product', 'product_photos/gW9ppY9BOCXvyLAcgEXRfUMNaXoRultOySkbVF9o.png', '\"[\\\"product_photos\\\\/YlZ6RWQxIerCurrsLmQ83Q9f8iWU1VuunQpLzNeU.png\\\",\\\"product_photos\\\\/DnWyD3u4RO104ZhUTWjudNT4spI1YbBEcOjjoGjw.png\\\",\\\"product_photos\\\\/FUcd4Y0veBLCKqjSSRJXIf6dgMohU3lLJ8PvmEwI.png\\\"]\"', '2024-07-01 18:42:42', '2024-07-01 18:42:42'),
                (4, 1, 'scooter-xiaomi-6e0d6249be766cde', 'Xiaomi', 'T2S Pro', 'El Scooter Eléctrico Monorim TS2 es un modelo discreto que viene de fábrica con un kit de 10 pulgadas y neumáticos antipinchazos. Cuenta con un motor de 500W, lo que le permite subir pendientes de hasta 25 grados, aprovechando su batería de 48V que lo hace muy versátil. Además, le añadimos suspensión delantera y un mástil reforzado con un sistema de plegado mejorado, lo que disminuye considerablemente las holguras típicas de los modelos convencionales de Xiaomi.', 'Eco mode 15mk/h – modo normal 20km/h – modo sport 50km/h', '19499.00', 0, 'new', 'product', 'product_photos/B9kvtOSINOxBa8Hwd7rKyctoGfZPhqouwvVuRcMt.png', '\"[\\\"product_photos\\\\/e7mukRXtERXSv6nWiQ6m8nw98cKVrioyyveT0DvJ.png\\\",\\\"product_photos\\\\/bRAZh2FQ9QPdTNXmlixghavXyaxuJrKQW5nGZDxH.png\\\",\\\"product_photos\\\\/dIOUGvDbqF9evFvSux1V2DhuvshlstYgnaUIm254.png\\\"]\"', '2024-07-02 04:31:12', '2024-07-02 04:31:12'),
                (5, 2, 'pieza-honey-whale-d9f3dd392e53ebaa', 'Honey Whale', 'Llanta Sólida 10 pulgadas x 2.75', 'Neumático sólido 10x2,75-6,5 para scooter eléctrico de 10 pulgadas, a prueba de pinchazos, accesorios de neumáticos todoterreno sin necesidad de inflado.\r\n\r\nEste neumático mide 10x2,75-6,5. Su diseño hueco ofrece un mejor efecto de absorción de impactos y puede reemplazar neumáticos de 10x2,70-6,5, 255x70, 10x2,50-6,5 y otros modelos.', 'Neumático sólido de 10x2,75-6,5', '690.00', 0, 'new', 'product', 'product_photos/URXziqMEUtiwNsFPKpK3Kq77oBFrx9ntUHQqn8WQ.png', '\"[\\\"product_photos\\\\/hJ0bgAA2Eze00zhk6oltW2j3jLrbKU1Mt1A5OwZH.png\\\",\\\"product_photos\\\\/OLuE0sjVd73jHVgMspeA1STP9agVuAaf1R3y2MXN.png\\\",\\\"product_photos\\\\/wabutASqmzD4xmJO0Kqq2bZSbIOHjZXNIwGKjlxH.png\\\"]\"', '2024-07-06 15:27:11', '2024-07-06 15:27:11'),
                (6, 4, NULL, 'Honey Whale', 'Llanta Sólida 10 pulgadas x 2.75 (Instalación)', 'Neumático sólido 10x2,75-6,5 para scooter eléctrico de 10 pulgadas, a prueba de pinchazos, accesorios de neumáticos todoterreno sin necesidad de inflado.\r\n\r\nEste neumático mide 10x2,75-6,5. Su diseño hueco ofrece un mejor efecto de absorción de impactos y puede reemplazar neumáticos de 10x2,70-6,5, 255x70, 10x2,50-6,5 y otros modelos.', 'Neumático sólido de 10x2,75-6,5', '1040.00', 0, 'new', 'service', 'product_photos/wabutASqmzD4xmJO0Kqq2bZSbIOHjZXNIwGKjlxH.png', '\"[\\\"product_photos\\\\/hJ0bgAA2Eze00zhk6oltW2j3jLrbKU1Mt1A5OwZH.png\\\",\\\"product_photos\\\\/OLuE0sjVd73jHVgMspeA1STP9agVuAaf1R3y2MXN.png\\\",\\\"product_photos\\\\/wabutASqmzD4xmJO0Kqq2bZSbIOHjZXNIwGKjlxH.png\\\"]\"', '2024-07-06 15:27:12', '2024-07-06 15:27:12'),
                (7, 2, 'pieza-cst-5f06e8fb61bd8a33', 'CST', 'Llanta 9.5 x 2.5 Niu', 'CST 9.5 x 2.50 neumático sin cámara de 9.5 pulgadas para NIU KQi3 Scooter eléctrico 9.5 x 2.50', '23,39 x 23,09 x 7,7 cm; 50 g', '800.00', 10, 'new', 'product', 'product_photos/GPKerrC1u7CDV6UXsWE248T379ciQ3LH3dckKNgz.png', '\"[\\\"product_photos\\\\/8eQNWEk0BrBWHxaJp4jrV6VFJcVrZpHem2n0AIAV.png\\\",\\\"product_photos\\\\/JkNAjqRmtKh3OrD2X2k1h3ujsbN324y1E95ykRsl.png\\\",\\\"product_photos\\\\/QY7vcSO9idODLX3cxCWV63yWCI2A992kY1kss7Yt.png\\\"]\"', '2024-07-07 11:34:57', '2024-07-07 11:34:57'),
                (8, 4, NULL, 'CST', 'Llanta 9.5 x 2.5 Niu (Instalación)', 'CST 9.5 x 2.50 neumático sin cámara de 9.5 pulgadas para NIU KQi3 Scooter eléctrico 9.5 x 2.50', '23,39 x 23,09 x 7,7 cm; 50 g', '950.00', 10, 'new', 'service', 'product_photos/QY7vcSO9idODLX3cxCWV63yWCI2A992kY1kss7Yt.png', '\"[\\\"product_photos\\\\/8eQNWEk0BrBWHxaJp4jrV6VFJcVrZpHem2n0AIAV.png\\\",\\\"product_photos\\\\/JkNAjqRmtKh3OrD2X2k1h3ujsbN324y1E95ykRsl.png\\\",\\\"product_photos\\\\/QY7vcSO9idODLX3cxCWV63yWCI2A992kY1kss7Yt.png\\\"]\"', '2024-07-07 11:34:57', '2024-07-07 11:34:57'),
                (9, 2, 'pieza-cst-7447a60cf8165870', 'CST', 'Llanta 8.5 pulgadas', 'Llanta de reemplazo de 8.5 pulgadas que sirve tanto para la rueda delantera como para la rueda trasera, la llanta es resistente al desgaste y ofrece una tracción excelente. Ligera y duradera.', 'Llanta de reemplazo de 8.5 pulgadas', '500.00', 0, 'new', 'product', 'product_photos/HeXGxpWUZx65oxdwRcDhLUZLzm0ia65aVNfJWRWM.png', '\"[\\\"product_photos\\\\/amniUvZESiLHrkTBxzNUF02jMVzW19U7Qo3wRlGN.png\\\",\\\"product_photos\\\\/QmwZESbmkmkiNHipG13EOBFkNv4RGQk3ZbSoEsJz.png\\\",\\\"product_photos\\\\/Jh4e6Tql0xe4JChG6m0VhGvIyfdU8UL6y9mVpb1e.png\\\"]\"', '2024-07-08 03:39:00', '2024-07-08 03:39:00'),
                (10, 4, NULL, 'CST', 'Llanta 8.5 pulgadas (Instalación)', 'Llanta de reemplazo de 8.5 pulgadas que sirve tanto para la rueda delantera como para la rueda trasera, la llanta es resistente al desgaste y ofrece una tracción excelente. Ligera y duradera.', 'Llanta de reemplazo de 8.5 pulgadas', '750.00', 0, 'new', 'service', 'product_photos/Jh4e6Tql0xe4JChG6m0VhGvIyfdU8UL6y9mVpb1e.png', '\"[\\\"product_photos\\\\/amniUvZESiLHrkTBxzNUF02jMVzW19U7Qo3wRlGN.png\\\",\\\"product_photos\\\\/QmwZESbmkmkiNHipG13EOBFkNv4RGQk3ZbSoEsJz.png\\\",\\\"product_photos\\\\/Jh4e6Tql0xe4JChG6m0VhGvIyfdU8UL6y9mVpb1e.png\\\"]\"', '2024-07-08 03:39:00', '2024-07-08 03:39:00'),
                (11, 1, 'scooter-xiaomi-f36c94af6482b78f', 'Xiaomi', 'T2S Pro +', 'El scooter eléctrico Monorim TS2 PRO+ se distingue de su hermano T2S PRO por tener una doble suspensión. Este modelo, que no llama mucho la atención, viene de fábrica con un kit de neumáticos de 10 pulgadas a prueba de pinchazos y un motor de 500W, capaz de subir pendientes con inclinaciones de hasta 25 grados gracias a su batería de 48V. Su mástil reforzado con un sistema de plegado mejorado reduce significativamente las holguras comunes en los modelos convencionales de Xiaomi, lo que lo convierte en un scooter muy versátil.', 'Eco mode 15mk/h – modo normal 20km/h – modo sport 50 km/h', '23499.00', 0, 'new', 'product', 'product_photos/lPPkrvt3Kq9u1Kz64q4v07vV7WIKvWsxgasEMPX0.png', '\"[\\\"product_photos\\\\/C4L49zPaxgY1svWkuWcUTO1bq0RJRfBx9EUGTHXb.png\\\",\\\"product_photos\\\\/OOowYUdbEH0QL5UCytjDbA1LsjJ7jNAV93FtAOIF.png\\\",\\\"product_photos\\\\/thz4oMK1pdqIXew5DTY2E2wLZPCPKaoZv2LcIgwa.png\\\",\\\"product_photos\\\\/xwsNcNrCRvfRMz3OLQSpVW1hsW7WeyoH2um5GNdu.png\\\"]\"', '2024-07-08 03:42:16', '2024-07-08 03:42:16'),
                (12, 3, 'pieza-genericos-4nd785774dlm3430', 'Genericos', 'Guardabarros trasero', 'Diseño ligero: el guardabarros para scooter eléctrico tiene un diseño liviano que no agrega demasiada carga y garantiza una conducción eficiente.\r\nDiseño a prueba de salpicaduras: el guardabarros del scooter evita que el barro y el agua salpiquen durante la conducción, lo que hace que la experiencia de conducción sea agradable y ordenada.\r\nFácil de reemplazar: el guardabarros del scooter es fácil de instalar y reemplazar, lo que aumenta la vida útil del scooter.', 'Guardabarros trasero corto stop y tornillos', '480.00', 10, 'new', 'product', 'product_photos/IZ7R7ZHi78nceMtEsx3Y0pEmfJeemM2hIQBfuTkj.png', '\"[\\\"product_photos\\\\/jhKYLgSY9fT5FKvjWKh27Fq0CflYofeeWgzMjkhZ.png\\\",\\\"product_photos\\\\/iR76N69xUToBQeaEUDemg1ZwZKMWhiBPIqpbhGSt.png\\\",\\\"product_photos\\\\/16H6MWIcZ6G5PRu4l5H9DqpqZomVx2shDlFgdCdN.png\\\"]\"', '2024-07-08 07:26:30', '2024-07-08 07:26:30'),
                (13, 2, 'pieza-xiaomi-8a56757f2ccd6b7a', 'Xiaomi', 'Cargador Original', 'Protección múltiple: el adaptador de carga de batería ofrece protección inteligente contra sobrevoltaje, sobrecarga y cortocircuitos. Es seguro y confiable, con una entrada de 100-240V AC50/60Hz y una salida de 42V 1.5A.\r\n\r\nCompatibilidad fuerte: esta fuente de alimentación proporciona un voltaje estable y seguro, con una fuerte compatibilidad para satisfacer las necesidades de diferentes dispositivos.\r\n\r\nBajo ruido: funciona con poco ruido, es duradero, resistente y tiene una larga vida útil.\r\n\r\nMaterial de calidad: este cargador de batería para scooter eléctrico está hecho de una carcasa de plástico de ingeniería de PC, resistente a altas temperaturas y al fuego, lo que lo hace más seguro de usar.\r\n\r\nVelocidad de carga rápida: carga más rápido y de forma segura. La carcasa, hecha de plástico de alta calidad, tiene una apariencia suave y sin impurezas.', 'Cargador Original con adaptador de batería de 42V y 1,7a, accesorios para Scooter', '600.00', 15, 'new', 'product', 'product_photos/gUfCRj4S3emZD8yIsCicdIRtfNH05qEpsLDKr2xO.png', '\"[\\\"product_photos\\\\/0kJuJVaDfvReVs1gdGDipVdMvodf9VO2XI06PwOS.png\\\",\\\"product_photos\\\\/ukKpH41Net90r69NyE5w2IbZqRoWWgeWoG7oyOWL.png\\\"]\"', '2024-07-10 07:22:28', '2024-07-10 07:22:28'),
                (14, 3, 'accesorio-xiaomi-ocslxpnqzwu0etuo', 'Xiaomi', 'Set de empuñaderas de goma color beige', 'Mejora tu viaje con la Empuñadura Universal para Manillar de Motocicleta de surpassme. Este accesorio antideslizante de goma está diseñado para scooters, bicicletas eléctricas y motocicletas con manillares de 7/8 pulgadas (22mm).', 'Empuñadura Universal para manillar de motocicleta, accesorio de goma antideslizante para Scooter, e-bike, 7/8 pulgadas, 22mm', '240.00', 0, 'new', 'product', 'product_photos/6cHAtN12vFa3wPm2fZgNXJXz4XGNJPUbkuB008Xh.png', NULL, '2024-08-07 18:43:42', '2024-08-07 18:43:42'),
                (15, 2, 'piezas-genericos-dzzfhqtssgvounnz', 'Genericos', 'Chicote de freno', 'Cable universal de freno o chicote de repuesto para scooters eléctricos', 'Cable de freno chicote para scooters eléctricos', '180.00', 0, 'new', 'product', 'product_photos/6RD1g3GIhPiIpAqrlTSRpMeHBB8XYRbq2FPZmkaZ.png', '\"[\\\"product_photos\\\\/G9WvuGX8vAihUye1NdnCRNmEuigFLmxTN6JL2j9K.png\\\"]\"', '2024-08-09 05:22:56', '2024-08-09 05:22:56'),
                (16, 4, NULL, 'Genericos', 'Chicote de freno (Instalación)', 'Cable universal de freno o chicote de repuesto para scooters eléctricos', 'Cable de freno chicote para scooters eléctricos', '240.00', 0, 'new', 'service', 'product_photos/G9WvuGX8vAihUye1NdnCRNmEuigFLmxTN6JL2j9K.png', '\"[\\\"product_photos\\\\/G9WvuGX8vAihUye1NdnCRNmEuigFLmxTN6JL2j9K.png\\\"]\"', '2024-08-09 05:22:56', '2024-08-09 05:22:56');
                */
                [
                    'category_id' => 1,
                    'code' => 'scooter-monorim-7e5965678e7973a7',
                    'brand' => 'Monorim',
                    'name' => 'Suv S1',
                    'description' => 'El scooter Monorim SUV S1 es una opción ideal para quienes buscan un vehículo eléctrico con gran potencia y versatilidad. Equipado con un motor de 500W en cada rueda, este scooter puede alcanzar una velocidad máxima de 65 km/h en áreas privadas y ofrece una autonomía de hasta 50 km con una sola carga. Además, dispone de un sistema de suspensión doble, estabilizador de dirección, intermitentes y una plataforma iluminada, emite un sonido similar al de una moto al acelerar, y cuenta con neumáticos antipinchazos para que nunca te quedes varado.',
                    'description_min' => '48v 20Ah, dual 1000w, velocidad máxima 60km/h',
                    'price' => '32999.00',
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
                    'created_at' => '2024-07-01 07:50:31',
                    'updated_at' => '2024-07-01 07:50:31',
                ], 
                [
                    'category_id' => 1,
                    'code' => 'scooter-xiaomi-f7de35e174c41ea2',
                    'brand' => 'Xiaomi',
                    'name' => 'T0s',
                    'description' => 'El T0S es un scooter diseñado para resistir el uso diario. A pesar de ser el modelo más asequible de la marca, está equipado con una batería de 7.8Ah a 36V, capaz de recorrer hasta 25 km con una sola carga. Tiene un sistema de plegado reforzado con doble vástago y un mecanismo de plegado mejorado. En términos de comodidad, como todos nuestros modelos, incluye el kit de 10 pulgadas, en este caso con neumáticos de aire y la suspensión delantera MONORIM©, asegurando trayectos más suaves.',
                    'description_min' => 'T0S / 36V / 7,8Ah',
                    'price' => '17499.00',
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
                    'created_at' => '2024-07-01 10:45:50',
                    'updated_at' => '2024-07-01 10:45:50',
                ]
            ],
        ]);
    }
}
