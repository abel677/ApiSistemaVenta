<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Categories::where('state',1)->get();
        return response()->json($category);
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
            'category' => 'required|string|max:50',
            'image'=>'required|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
        ]);

        $validData['image'] = Storage::url($validData['image']->store('public/img'));


        $category = Categories::create([
           'category' => $validData['category'],
           'image' =>$validData['image'],
           'state' => 1
        ]);
        return response()->json(['message'=>'Categoria registrada'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Categories::find($id);
        return response()->json($category,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function edit(Categories $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validData = $request->validate([
            'category' => 'required|string|max:50',
            'image' => 'required'
        ]);
        $category = Categories::find($id);
        
        
        $category->category = $validData['category'];
        $category->save();
        
        return response()->json(['message'=>'Categoria actualizada'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Categories::find($id);
        if(is_null($category)){
            return response()->json(['message'=>'No hay registro']);
        }
        $category->state = false;
        $category->save();
        return response()->json(['message'=>'Categoria eliminada']);
    }
}
