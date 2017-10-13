<?php

namespace App\Http\Controllers\Api;
use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Sale;
use App\Rental;
class StatisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $now = Carbon::now()->format('Y-m-d');
       $startDay = $now.' 00:00:00';
       $endDay = $now.' 23:59:00';

       //get sales of day
       $sales = DB::table('product_sale')
           ->join('products','products.id','=','product_sale.product_id')
           ->select('products.name','product_sale.product_id',  DB::raw('SUM(product_sale.quantity) as total'))
           ->whereBetween('product_sale.created_at', [$startDay, $endDay])
           ->groupBy('product_sale.product_id','products.name')
           ->orderBy('total', 'DESC')
           ->limit(4)
           ->get();
        //get rentals of daay
        $rentals = DB::table('product_rental')
            ->join('products','products.id','=','product_rental.product_id')
            ->select('products.name','product_rental.product_id',  DB::raw('SUM(product_rental.quantity) as total'))
            ->whereBetween('product_rental.created_at', [$startDay, $endDay])
            ->groupBy('product_rental.product_id','products.name')
            ->orderBy('total', 'DESC')
            ->limit(4)
            ->get();
        $gainSalesToday = DB::table('product_sale')
            ->select(DB::raw('SUM(price) as total'))
            ->whereBetween('created_at',[$startDay,$endDay])
            ->get();
        $gainRentalsToday = DB::table('product_rental')
            ->select(DB::raw('SUM(price * quantity) as total'))
            ->whereBetween('created_at',[$startDay,$endDay])
            ->get();
        $products = DB::table('products')
            ->orderBy('stock','ASC')
            ->limit(4)
            ->get();
        $productsOnRental = DB::table('rentals')
            ->where('returned' , 0 )
            ->count();
       return response()->json(['sales' => $sales,
                                'rentals' => $rentals,
                                'products' => $products,
                                'gainSalesTotal' => $gainSalesToday,
                                'gainRentalsTotal' => $gainRentalsToday,
                                'productOnRental' => $productsOnRental] );
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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
