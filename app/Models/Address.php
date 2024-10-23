<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ["user_id", "token", "street", "external_number", "internal_number", "neighborhood", "city", "state", "postal_code", "country", "reference"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
