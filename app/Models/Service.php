<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // <--- ¡Asegúrate de que 'name' esté aquí!
        'number_of_profiles',
        'product_link',
    ];
}