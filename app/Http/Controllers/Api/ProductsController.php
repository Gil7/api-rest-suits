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
        $products = Product::all();
        return response()->json(['products' => $products, 'success' => true],200);
    }
    //create a new product
    public function store(Request $request){
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
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
    //delete a product
    public function delete($id){
        try{
            $product = Product::findOrFail($id);
            $product->delete();
            return response()->json(['success'=> true, 'message' => 'product deleted correctly']);
        }catch (Exception $e){
            return response()->json(['success' => false, 'message' => 'Error deleting product']);
        }
    }
    public function addSizes($idProduct, $sizes){
        $product = Product::find($idProduct);
        $product->sizes()->attach($sizes);

    }

}
