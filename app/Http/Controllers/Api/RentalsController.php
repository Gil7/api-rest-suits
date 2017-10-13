<?php

namespace App\Http\Controllers\Api;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Rental;
use Carbon\Carbon;
class RentalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rentals = DB::table('product_rental as pr')
            ->join('products as p','p.id','=','pr.product_id')
            ->join('rentals as r','r.id','=','pr.rental_id')
            ->select('p.name','r.id','pr.created_at','pr.price','pr.quantity','r.nameClient','r.returned','r.return')
            ->where('r.returned','0')
            ->get();
        return response()->json($rentals);
    }
    public function rentalstoday(){
        $now = Carbon::now()->format('Y-m-d');
        $startDay = $now.' 00:00:00';
        $endDay = $now.' 23:59:00';
        $rentals = DB::table('product_rental as pr')
            ->join('products as p','p.id','=','pr.product_id')
            ->join('rentals as r','r.id','=','pr.rental_id')
            ->select('p.name','pr.created_at','pr.price','pr.quantity','r.nameClient','r.returned','r.return')
            ->whereBetween('pr.created_at', [$startDay, $endDay])
            ->get();
        return response()->json(['rentals' => $rentals]);

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
        $limitDate = date("Y-m-d", strtotime($request->return) );
        //create a new rental//get the user from request
        $token  = \JWTAuth::getToken();
        $user = \JWTAuth::toUser($token);
        //end to get user
        $rental = new Rental();
        $rental->return = $limitDate;
        $rental->nameClient = $user->name;
        $rental->save();
        //insert data in the intermediate table
        $rental->products()->attach([$request->product_id  => ['quantity' => $request->quantity, 'price' => $request->price, 'created_at' => $rental->created_at]]);
        //update stock
        $product = Product::find($request->product_id);
        $product->stock -= $request->quantity;
        //save new stock
        $product->save();
        //return data about new rental and the product updated
        return response()->json(['success' => true, 'product' => $product, 'rental' => $rental],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rental = Rental::find($id);
        $rental->products;
        return response()->json($rental);
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

    //this methods is to update the state of rental, in case the client return the product
    public function update(Request $request, $id)
    {

        $rental = Rental::find($id);
        foreach ($rental->products as $product) {
            $currenProduct = Product::find($product->id);
            $currenProduct->stock += $product->pivot->quantity;
            $currenProduct->save();
        }
        $rental->returned = 1;
        $rental->save();
        return response()->json($rental);

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
