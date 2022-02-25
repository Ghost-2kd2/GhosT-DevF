<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', [
            'except' => [
                'login',
                'register',
                'stripe',
                'index',
                'productList',
                'addproduct',
                'productImages',
                'saveImages',
                'getproduct',
                'updateproduct',
                'deleteproduct',
                'getCat',
                'addCat',
                'getCat',
                'updateCat',
                'deleteCat',
                'addSubCat',
                'getSubCat',
                'updateSubCat',
                'deleteSubCat',
            ],
        ]);
    }
    //<--------------------------LOGIN-------------------------->
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        if (!($token = JWTAuth::attempt($credentials))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = auth()
            ->user()
            ->hasRole('administrator');
        if ($user) {
            DB::table('users')->where('email', $request->email)->update(['msg_token' => $request->msg_token]);
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'user' => auth()->user(),
            ], 200);
        }
        return response()->json([
            'message' => 'UnAuthorized User',
        ], 401);

    }
    //<------------------------------REGISTER------------------------------>
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
            // 'user_type' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'user_type' => $request['user_type'],
            'password' => Hash::make($request['password']),
        ]);
        $user->attachRole('administrator');

        return response()->json(
            [
                'message' => 'User successfully registered',
                'user' => $user,
            ],
            201
        );
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    public function userProfile()
    {
        return response()->json(auth()->user());
    }

    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' =>
            auth()
                ->factory()
                ->getTTL() * 60,
            'user' => auth()->user(),
        ]);
    }

    //<---------------------------------INDEX---------------------------------->
    public function index()
    {
        $tot_products = product::productTotal()->count();
        // $tot_active = product::productTotal()
        //     ->where('product_stock', 1)
        //     ->count();
        // $tot_inactive = product::productTotal()
        //     ->where('product_stock', 0)
        //     ->count();
        $productList = product::getproductsSearch('', '', '');
        // $product_popularity = 0;
        return response()->json(
            [
                'status' => 1,
                'product_total' => $tot_products,
                // 'tot_active' => $tot_active,
                // 'tot_inactive' => $tot_inactive,
                // 'product_popularity' => $product_popularity,
                'product_list' => $productList,

            ],
            200
        );
    }

    //<-----------------------Paginated class for product details-------------------->
    public function productList(Request $request)
    {
        $query = $request->get('query');
        $products = products::getproductsSearch($query);

        return response()->json(
            [
                'status' => 1,
                'products' => $products,
            ],
            200
        );
    }
    //<---------------------------------products images------------------------------------------>
    public function saveImages(Request $request)
    {

        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',

        ]);
        $name = $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->store('public/images');

        $save = new Photo;
        $save->name = $name;
        $save->path = $path;
        $save->save();
        $image = images::create([
            'product_id' => $request->product_id,
            'image_name' => $name,
            'image_path' => $path,
            'created_at' => carbon::now(),
            'updated_at' => carbon::now(),
        ]);

        // return redirect('upload-image')->with('status', 'Image Has been uploaded');
        return response()->json(['status' => 1, 'image_details' => $image], 200);
    }
    // public function productImages(Request $request)
    // {
    //     $check = productImages::create([
    //         'product_id' => $request->product_id,
    //         'product_imgs' => $request->product_imgs,
    //         'created_at' => carbon::now(),
    //     ]);
    //     return response()->json([
    //         'status' => 1,
    //         'product_image' => 'product image added successfully',
    //     ]);
    // }

    // <----------------------products CRUD operations--------------------------->
    public function addproduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string',
            'product_description' => 'required|string',
            // 'product_type' => 'required|string',
            'product_cat_id' => 'required|integer',
            'product_subCat_id' => 'required|int',
            'product_Tertiary_id' => 'required|string',
            // 'product_size' => 'required|string',
            'product_purchase_price' => 'integer',
            'product_quantity' => 'integer',
            'product_profit' => 'integer',
            'product_offer' => 'required|integer',
            'product_customer_price' => 'required|integer',
            //'product_images' => 'required|text',
            // 'created_by' => 'required|string',
            // 'product_stock' => 'required|tinyInteger',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $request->errors()], 202);
        }
        $check = products::create([
            'product_name' => $request->product_name,
            'product_description' => $request->product_description,
            // 'product_type' => $request->product_type,
            'product_cat_id' => $request->product_cat_id,
            'product_subCat_id' => $request->product_subCat_id,
            'product_Tertiary_id' => $request->product_Tertiary_id,
            // 'product_size' => $request->product_size,
            'product_purchase_price' => $request->product_purchase_price,
            'product_quantity' => $request->product_quantity,
            'product_profit' => $request->product_profit,
            'product_offer' => $request->product_offer,
            'product_customer_price' => $request->product_customer_price,
            //"product_images"=>$request->product_images,
            // 'created_by' => $request->created_by,
            // 'product_stock' => $request->product_stock,
            'created_at' => Carbon::now(),
        ]);
        return $this->resp($check, 'product added Successfully');
    }

    public function getproduct(Request $request)
    {
        $products = DB::table('products')->get();
        return response()->json(['status' => 1, 'products' => $products], 200);
    }
    public function updateproduct(Request $request)
    {
        $updateproduct = DB::table('products')
            ->where('id', $request->id)
            ->orWhere('product_name', $request->product_name)
            ->update([
                'product_name' => $request->product_name,
                'product_description' => $request->product_description,
                // 'product_type' => $request->product_type,
                'product_cat_id' => $request->product_cat_id,
                'product_subCat_id' => $request->product_subCat_id,
                'product_Tertiary_id' => $request->product_Tertiary_id,
                // 'product_size' => $request->product_size,
                'product_purchase_price' => $request->product_purchase_price,
                'product_quantity' => $request->product_quantity,
                'product_profit' => $request->product_profit,
                'product_offer' => $request->product_offer,
                'product_customer_price' => $request->product_customer_price,
                //"product_images"=>$request->product_images,
                // 'created_by' => $request->created_by,
                // 'product_stock' => $request->product_stock,
                'updated_at' => Carbon::now(),
            ]);
        return $this->resp($check, 'product details updated Successfully');
    }
    public function deleteproduct(Request $request)
    {
        $check = DB::table('products')
            ->where('id', $request->id)
            ->delete();
        return $this->resp($check, 'product Successfully Deleted');
    }

    //<--------------------------------Category CRUD functions----------------------------------------->
    public function getCat()
    {
        $check = DB::table('product_categories')->get();
        return response()->json(['status' => 1, 'message' => $check], 200);
    }
    public function addCat(Request $request)
    {
        $check = DB::table('product_categories')->insert([
            'product_cat_name' => $request->cat_name,
        ]);
        return $this->resp($check, 'Category Successfully Added');
    }
    public function deleteCat(Request $request)
    {
        $check = DB::table('product_categories')
            ->where('id', $request->id)
            ->delete();
        return $this->resp($check, 'Category Successfully Deleted');
    }
    public function updateCat(Request $request)
    {
        $check = DB::table('product_categories')
            ->where('id', $request->id)
            ->update(['product_cat_name' => $request->cat_name]);
        return $this->resp($check, 'Category Successfully Updated');
    }

    // <--------------------------subCategory CRUD operations------------------------------------------>
    public function getSubCat(Request $request)
    {
        $check = DB::table('product_sub_categories')->get();
        return response()->json(['status' => 1, 'message' => $check], 200);
    }
    public function addSubCat(Request $request)
    {
        $check = DB::table('product_sub_categories')->insert([
            'product_cat_id' => $request->cat_id,
            'product_subCat_name' => $request->subCat_name,
        ]);
        return $this->resp($check, 'subcategory Successfully added');
    }
    public function updateSubCat(Request $request)
    {
        $check = DB::table('product_sub_categories')
            ->where('id', $request->id)
            ->update([
                'product_cat_id' => $request->cat_id,
                'product_subCat_name' => $request->subCat_name,
            ]);
        return $this->resp($check, 'subcategory Successfully Updated');
    }
    public function deleteSubCat(Request $request)
    {
        $check = DB::table('product_sub_categories')
            ->where('id', $request->id)
            ->delete();
        return $this->resp($check, 'subCategory Successfully Deleted');
    }

    // <--------------------------subCategory CRUD operations------------------------------------------>
    public function getTerCat(Request $request)
    {
        $check = DB::table('product_tertiary_categories')->get();
        return response()->json(['status' => 1, 'message' => $check], 200);
    }
    public function addTerCat(Request $request)
    {
        $check = DB::table('product_tertiary_categories')->insert([
            'product_cat_id' => $request->cat_id,
            'product_terCat_name' => $request->subCat_name,
        ]);
        return $this->resp($check, 'Tertiary Category Successfully added');
    }
    public function updateTerCat(Request $request)
    {
        $check = DB::table('product_tertiary_categories')
            ->where('id', $request->id)
            ->update([
                'product_cat_id' => $request->cat_id,
                'product_terCat_name' => $request->subCat_name,
            ]);
        return $this->resp($check, 'Tertiary Category Successfully Updated');
    }
    public function deleteTerCat(Request $request)
    {
        $check = DB::table('product_tertiary_categories')
            ->where('id', $request->id)
            ->delete();
        return $this->resp($check, 'Tertiary Category Successfully Deleted');
    }
    //<--------------------Common Response function for CRUD Operations----------------->
    public function resp($check, $name)
    {
        if ($check) {
            return response()->json(
                [
                    'status' => 1,
                    'message' => $name,
                ],
                200
            );
        }
        return response()->json(
            [
                'status' => 0,
                'message' => 'Error, try again later!',
            ],
            201
        );
    }

    public function addMassProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string',
            'product_description' => 'required|string',
            'product_cat_id' => 'required|integer',
            'product_subCat_id' => 'required|int',
            'product_Tertiary_id' => 'required|string',
            'product_purchase_price' => 'integer',
            'product_quantity' => 'integer',
            'product_profit' => 'integer',
            'product_offer' => 'required|integer',
            'product_customer_price' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $request->errors()], 202);
        }
        // foreach ($products as $product) {

        if ($product_quantity > 1) {

            for ($i = 1; $i <= $product_quantity; $i++) {
                $check = products::create([
                    'product_name' => $request->product_name,
                    'product_description' => $request->product_description,
                    'product_cat_id' => $request->product_cat_id,
                    'product_subCat_id' => $request->product_subCat_id,
                    'product_Tertiary_id' => $request->product_Tertiary_id,
                    'product_purchase_price' => $request->product_purchase_price,
                    'product_quantity' => $request->product_quantity,
                    'product_profit' => $request->product_profit,
                    'product_offer' => $request->product_offer,
                    'product_customer_price' => $request->product_customer_price,
                    'created_at' => Carbon::now(),
                ]);
            }
            return $this->resp($check, "product's added Successfully");
        } else {
            $check = products::create([
                'product_name' => $request->product_name,
                'product_description' => $request->product_description,
                'product_cat_id' => $request->product_cat_id,
                'product_subCat_id' => $request->product_subCat_id,
                'product_Tertiary_id' => $request->product_Tertiary_id,
                'product_purchase_price' => $request->product_purchase_price,
                'product_quantity' => $request->product_quantity,
                'product_profit' => $request->product_profit,
                'product_offer' => $request->product_offer,
                'product_customer_price' => $request->product_customer_price,
                'created_at' => Carbon::now(),
            ]);
        }

        return $this->resp($check, "product's added Successfully");

    }

    // }

    public function sample()
    {
        $user = auth()->user();
        return json_encode($user);
    }
}