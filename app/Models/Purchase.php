<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'quantity', 'purchase_price', 'total_cost', 'supplier_name', 'supplier_contact', 'purchase_date', 'invoice_number'
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
