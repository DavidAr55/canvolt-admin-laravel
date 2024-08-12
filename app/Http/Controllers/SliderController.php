<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Product;

class SliderController extends Controller
{
    public function create()
    {
        $sliders = Slider::all();
        $products = Product::orderBy('price', 'asc')
                           ->select('id', 'brand', 'name', 'description_min', 'price', 'discount', 'photo_main')
                           ->get();
        return view('canvolt-form.slider-canvolt', compact('sliders', 'products'));
    }

    public function store(Request $request)
    {
        $selectedProducts = $request->input('selected_products', []);

        // Borramos el contenido actual de Slider para agregar los nuevos productos
        Slider::truncate();

        foreach ($selectedProducts as $product_id) {
            $slider = new Slider();
            $slider->product_id = $product_id;
            $slider->save();
        }

        return redirect()->route('canvolt-form.create')->with('success', 'Productos actualizados en el slider');
    }
}
