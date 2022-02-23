<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_cat_name',

    ];
}