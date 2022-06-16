<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Products::where('state',1)->get();
        return response()->json($product,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'description' => 'required|string|max:255',
            'price' => 'required',
            'image'=>'required|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
            'id_categories' => 'required'
        ]);
  
        $validData['image'] = Storage::url($validData['image']->store('public/img'));

        $product = Products::create([
            'description' => $validData['description'],
            'price' => $validData['price'],
            'image' => $validData['image'],
            'state'=>true,
            'id_categories' => $validData['id_categories']
        ]);

        return response()->json(['message'=>'Producto registrado'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Products::find($id);
        return response()->json($product,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $product = DB::table('products')
        ->join('categories','products.id_categories','=','categories.id')
        ->select('products.*','categories.category')
        ->where('id_categories',$id)
        ->where('products.state',1)
        ->get();
        return response()->json($product,200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validData = $request->validate([
            'description' => 'required|string|max:255',
            'price' => 'required',
            'image' => 'required',
            'id_categories' => 'required'
        ]);
        $product = Products::find($id);
        $product->description = $validData['description'];
        $product->price = $validData['price'];
        $product->image = $validData['image'];
        $product->id_categories = $validData['id_categories'];
        $product->save();
        

        return response()->json(['message'=>'Producto actualizado']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $product = Products::find($id);
        if(is_null($product)){
            return response()->json(['message'=>'No hay registro']);
        }
        $product->state = false;
        $product->save();
        return response()->json(['message'=>'Producto eliminado']);
    }
}
