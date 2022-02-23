<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [

        'product_name',
        'plant_id',
        'product_id',
        'product_description',
        // 'product_type',
        'product_cat_id',
        'product_subCat_id',
        'product_tertiary_id',
        'product_status',
        // 'product_quantity',
        'product_purchase_price',
        // 'product_margin_price',
        // 'product_base_price',
        'product_profit',
        'product_offer',
        'product_customer_price',
        // 'product_images',
        // 'product_stock',
        // 'product_popularity',
    ];

    protected $hidden = [];

    public static function productTotal()
    {
        $products = DB::table('products');
        return $products;
    }
    public static function getproductsSearch($query)
    {
        $products = DB::table('products')->orderByDesc('id');

        if ($query && !empty($query)) {
            $products = $products->where('products.product_name', 'LIKE', '%' . $query . '%')->orWhere('products.id', 'LIKE', '%' . $query . '%')
                ->orWhere('products.product_description', 'LIKE', '%' . $query . '%');
        }
        return $products->paginate(10);
    }
    public static function getproducts($query)
    {
        $products = DB::table('products');

        if ($query && !empty($query)) {
            $products = $products->where('products.product_id', 'LIKE', '%' . $query . '%')
                ->orWhere('products.product_name', 'LIKE', '%' . $query . '%')->orWhere('products.product_cat', 'LIKE', '%' . $query . '%')
                ->orWhere('products.product_subCat', 'LIKE', '%' . $query . '%');
        }
        return $products->paginate(PER_PAGE_LIMIT);
    }
    public function newproducts($query)
    {
        $product_recent = DB::table('products')->orderByDesc('id')->where('created_at');
        return $product_recent;
    }
    public function singleproduct(Request $request)
    {
        $single_product = DB::table('products')->where('id', $request->id)->first();
        return response()->json([
            'get_products' => $single_product,
        ], 200);
    }
    public function relatedproduct(Request $request)
    {
        $related_product = DB::table('products')->pluck('cat_id');
        //->select('products.*','cat_id')->get();
        return response()->json([
            'get_products' => $related_product,
        ], 200);
    }
}