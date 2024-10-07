<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Purchase;
use Carbon\Carbon;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Obtener todos los productos para asociarlos a las compras
        $products = Product::all();

        // Generar 12 compras, una para cada día desde hoy hasta hace 12 días
        for ($i = 0; $i < 12; $i++) {
            // Seleccionar un producto aleatorio
            $product = $products->random();
            
            // Generar una fecha desde hoy hasta hace 12 días
            $purchaseDate = Carbon::now()->subDays($i);

            // Calcular el precio total basado en una cantidad aleatoria
            $quantity = rand(1, 100);
            $purchasePrice = $product->price; // Asumimos que hay un campo `price` en `Product`
            $totalCost = $quantity * $purchasePrice;

            // Crear la compra
            Purchase::create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'purchase_price' => $purchasePrice,
                'total_cost' => $totalCost,
                'supplier_name' => 'Supplier ' . chr(65 + $i), // Nombres de proveedores ficticios
                'supplier_contact' => 'supplier' . $i . '@example.com',
                'purchase_date' => $purchaseDate,
                'invoice_number' => 'INV-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'created_at' => $purchaseDate,
                'updated_at' => $purchaseDate
            ]);
        }
    }
}
