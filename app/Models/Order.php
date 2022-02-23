<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'product_cat_id',
        'product_subCat_id',
        'product_Tertiary_id',
        'mobile_number',
        'customer_name',
        'product_name',
        'product_quantity',
        'product_cost_per_unit',
        'product_offer',
        'cgst',
        'sgst',
        'total_cost',
        'payment_mode',
    ];

}