<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTertiaryCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_cat_id',
        'product_subCat_id',
        'product_terCat_name',

    ];
}