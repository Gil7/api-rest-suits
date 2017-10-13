<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class ProductsController extends Controller
{
    //return all products registered
    public function index(){
        $products = Product::paginate(10);
        return [
            'paginate' => [
                'total' => $products->total(),
                'current_page' => $products->currentPage(),
                'per_page' => $products->perPage(),
                'last_page' => $products->lastPage(),
                'from' => $products->firstItem(),
                'to' => $products->lastPage()
            ],
            'products' => $products
        ];
    }
    //create a new product
    public function store(Request $request){
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'rental' => 'required',
            'stock' => 'required',
        ]);
        if ($validation->fails()){
            return response()->json(['success' => false, 'message' => 'All fields are needed']);
        }
        $product = Product::create($request->all());
        $product->sizes()->attach($request->sizes);
        return response()->json(['success' => true, 'product' => $product]);
    }
    //return an specific product
    public function show($id){
        $product = Product::find($id);
        $product->sizes;
        return response()->json($product);
    }
    public function productByName($name){
        $product = Product::where('name','like','%'.$name.'%')->get();
        return response()->json($product);
    }
    //update a product
    public function update(Request $request, $id){
        $product = Product::find($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->rental = $request->rental;
        $product->stock = $request->stock;
        $product->save();
        //remove the sizes from intermediate table
        $product->sizes()->detach();
        //refresh the data on the intermediate table :)
        $product->sizes()->attach($request->sizes);
        return response()->json($product);
    }
    //delete a product
    public function destroy($id){

        Product::destroy($id);
        return response()->json(['success' => true, 'message' => 'Product deleted correclty']);
    }
    public function addSizes($idProduct, $sizes){
        $product = Product::find($idProduct);
        $product->sizes()->attach($sizes);

    }

}
