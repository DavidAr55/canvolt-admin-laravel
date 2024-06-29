<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Inventory;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('inventory.add-item', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'description_min' => 'required|string|max:255',
            'price' => 'required|numeric',
            'discount' => 'required|numeric|min:0|max:99',
            'category_id' => 'required|exists:categories,id',
            'condition' => 'required|in:new,used',
            'type' => 'required|in:product,service',
            'stock' => 'required|integer',
            'photo_main' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = new Product();
        $product->brand = $request->brand;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->description_min = $request->description_min;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->category_id = $request->category_id;
        $product->condition = $request->condition;
        $product->type = $request->type;

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

        if ($request->type == 'product') {
            $product->inventory()->create(['stock' => $request->stock]);
        }

        return redirect()->route('products.index')->with('success', 'Producto añadido al inventario');
    }
}
