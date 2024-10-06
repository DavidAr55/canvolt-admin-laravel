<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function create()
    {
        $categories = Category::where('name', '!=', 'Servicios')->get();
        return view('inventory.add-item', compact('categories'));
    }

    public function store(Request $request)
    {
        // Definimos las reglas de validación según la categoría y si es un servicio
        $rules = [
            'brand' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'description_min' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'condition' => 'required|in:new,used',
            'stock' => 'required|integer',
            'photo_main' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'service_option' => 'nullable|integer'
        ];

        // Añadimos reglas de validación dinámicamente
        if ($request->category_id == 2 && $request->service_option == 1) {
            $rules['instalation_price'] = 'nullable|numeric';
            $rules['instalation_discount'] = 'nullable|numeric|min:0|max:99';
        } else {
            $rules['price'] = 'required|numeric';
            $rules['discount'] = 'required|numeric|min:0|max:99';
        }

        $request->validate($rules);

        try {
            $product = new Product();
            $categoryName = strtolower(Category::where('id', $request->category_id)->value('name'));
            $product->code = $categoryName . "-" . strtolower(strtr($request->brand, " ", "-") . "-" . str()->random(16));
            $product->brand = $request->brand;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->description_min = $request->description_min;
            $product->price = $request->price;
            $product->discount = $request->discount;
            $product->category_id = $request->category_id;
            $product->condition = $request->condition;
            $product->type = 'product';

            if ($request->hasFile('photo_main')) {
                $path = $request->file('photo_main')->store('product_photos', 'public');
                $product->photo_main = $path;
            }

            if ($request->hasFile('photos')) {
                $photos = [];
                foreach ($request->file('photos') as $photo) {
                    $path = $photo->store('product_photos', 'public');
                    $photos[] = $path;
                }
                $product->photos = json_encode($photos);
            }

            $product->save();

            $product->inventory()->create(['stock' => $request->stock]);

            // Crear un registro adicional como servicio si se cumple la condición
            if ($request->category_id == 2 && $request->service_option == 1) {
                $serviceProduct = new Product();
                $serviceProduct->brand = $request->brand;
                $serviceProduct->name = $request->name . ' (Instalación)';
                $serviceProduct->description = $request->description;
                $serviceProduct->description_min = $request->description_min;
                $serviceProduct->price = $request->instalation_price;
                $serviceProduct->discount = $request->instalation_discount;
                $serviceProduct->category_id = 4; // Categoria de servicio
                $serviceProduct->condition = $request->condition;
                $serviceProduct->type = 'service';

                if ($request->hasFile('photo_main')) {
                    $serviceProduct->photo_main = $path; // Usamos la misma foto principal
                }

                if ($request->hasFile('photos')) {
                    $serviceProduct->photos = json_encode($photos); // Usamos las mismas fotos adicionales
                }

                $serviceProduct->save();
            }

            return redirect()->route('products.create')->with('success', 'Producto añadido al inventario');
        } catch (\Exception $e) {
            return redirect()->route('products.create')->with('error', 'Hubo un problema al añadir el producto: ' . $e->getMessage());
        }
    }

    public function show($product)
    {
        // Aquí puedes buscar el producto por nombre o por ID
        $productData = Product::where('name', $product)->firstOrFail();
        
        // Retorna la vista con los datos del producto
        return json_encode($productData);
    }
}
