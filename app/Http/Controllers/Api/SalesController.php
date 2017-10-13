<?php

namespace App\Http\Controllers\Api;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Sale;
use Carbon\Carbon;
class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sale::all();
        return response()->json($sales);
    }
    public function salestoday(){
        $now = Carbon::now()->format('Y-m-d');
        $startDay = $now.' 00:00:00';
        $endDay = $now.' 23:59:00';
        $sales = DB::table('product_sale as ps')
            ->join('products as p','p.id','=','ps.product_id')
            ->join('sales as s','s.id','=','ps.sale_id')
            ->select('p.name','ps.created_at','ps.price','ps.quantity','s.nameClient')
            ->whereBetween('ps.created_at', [$startDay, $endDay])
            ->get();
        return response()->json(['sales' => $sales]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //get the user from request
        $token  = \JWTAuth::getToken();
        $user = \JWTAuth::toUser($token);
        //end to get user
        $sale = new Sale();
        $sale->nameClient = $user->name;
        $sale->save();
        $sale->products()->attach([$request->product_id => [ 'quantity' => $request->quantity, 'price' => $request->price, 'created_at' => $sale->created_at]]);
        $product = Product::find($request->product_id);
        $product->stock -= $request->quantity;
        $product->save();
        return response()->json(['success' => true, 'sale' => $sale, 'product' => $product]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sale = Sale::find($id);
        $sale->products;

        return response()->json($sale);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return response()->json($request->all());
        $sale = Sale::create($request->name);
        $sale->products()->attach([$request->product_id => [ 'quantity' => $request->quantity, 'price' => $request->price]]);
        return response()->json(['success' => true, 'sale' => $sale]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
