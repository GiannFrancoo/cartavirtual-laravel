<?php

namespace App\Http\Controllers\Panel;

use Exception;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::query()
                                ->orderBy('id','DESC')
                                ->get();
                     
        return view('panel.categories.index')->with('categories', $categories);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        try{
            $category = new Category();
            $category->name = $request->name;                   
            
            //check optional image field
            if($request->file('image')){
                $image = base64_encode(file_get_contents($request->file('image')->path()));
                $category->image = $image;
            }
            
            $category->save();
            
            return redirect()->route("panel.categories.index")->with("success", "Categoria guardada correctamente!");
        }
        catch(Exception $e){
            return redirect()->back()->with("error", "Ups! Error al guardar la categoria");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{ 
            $category = Category::findOrFail($id);
            return view('panel.categories.show')->with('category', $category);
        }
        catch(Exception $e){
            redirect()->back()->with('error', 'Ups! Error al mostrar la categoria!');
        }

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $category = Category::findOrFail($id);    
            return view('panel.categories.edit')->with("category", $category);
        }
        catch(Exception $e){
            return redirect()->back()->with('error', 'Ups! Error al editar la categoria');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        try{
            $category = Category::findOrFail($id);
            $category->name = $request->name;

            if($request->noImage){
                $category->image = null;               
            }
            else{
                if($request->file('image')){
                    $image = base64_encode(file_get_contents($request->file('image')->path()));
                    $category->image = $image;
                }
            }            

            $category->save();

            return redirect()->route("panel.categories.index")->with("success", "Categoria editada correctamente!");
        }
        catch(Exception $e){
            return redirect()->back()->with("error", "Ups! Error al editar la categoria");
        }        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $category = Category::with('items')->findOrFail($id);
            
            if($category->items->count()){
                return redirect()->route("panel.categories.index")->with("error", "La categoria contiene items, eliminelos primero!");
            }
        
            $category->delete();
        
            return redirect()->route("panel.categories.index")->with("success", "Categoria eliminada correctamente!");
        }
        catch(Exception $e){
            return redirect()->back()->with("error", "Ups! Error al eliminar la categoria");
        }
    }
}
