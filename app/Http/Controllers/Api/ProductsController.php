<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class ProductsController extends Controller
{
    public function index(){
        $products = Product::all();
        return response()->json(['products' => $products, 'success' => true],200);
    }
    public function store(Request $request){
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required'
        ]);
        if ($validation->fails()){
            return response()->json(['success' => false, 'message' => 'All fields are needed']);
        }
        $product = Product::create($request->all());
        return response()->json(['success' => true, 'product' => $product]);
    }
    public function show(Product $product){
        return response()->json($product);
    }
    public function delete($id){
        try{
            $prodcuct = Product::findOrFail($id);
            $prodcuct->delete();
            return response()->json(['success'=> true, 'message' => 'product deleted correctly']);
        }catch (Exception $e){
            return response()->json(['success' => false, 'message' => 'Error deleting product']);
        }
    }
}
