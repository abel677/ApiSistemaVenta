<?php

namespace App\Http\Controllers;

use App\Models\Cars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $car = DB::table('cars')
        ->join('products','cars.id_product','=','products.id')
        ->select('products.*','cars.*')
        ->where('cars.state',1)
        ->get();
        return response()->json($car,200);

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
        $validData = $request->validate([
            'quantity' => 'required|string|max:255',
            'total' => 'required',
            'id_product' => 'required'
        ]);

        Cars::create([
            'quantity' => $validData['quantity'],
            'total' => $validData['total'],
            'state' => 1,
            'id_product' => $validData['id_product']
        ]);

        return response()->json(['message'=>'Producto agregado al carrito']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car = DB::table('cars')
        ->join('products','cars.id_product','=','products.id')
        ->select('products.*','cars.*')
        ->where('products.id',$id)
        ->where('cars.state',1)
        ->get();
        return response()->json($car,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit($car)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$car)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car = Cars::find($id);
        if(is_null($car)){
            return response()->json(['message'=>'Registro no encontrado'],404);
        }
        $car->state = 0;
        $car->save();
        return response()->json(['message'=>'Producto eliminado del carrito']);
    }
}
