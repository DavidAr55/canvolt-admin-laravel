<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;

class InventoryController extends Controller
{
    public function index()
    {
        // Obtener todos los inventarios junto con los productos relacionados
        $inventories = Inventory::with('product')->get();

        // Devolver la vista con los inventarios
        return view('inventory.show-inventory', compact('inventories'));
    }
}
