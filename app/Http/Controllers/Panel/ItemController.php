<?php

namespace App\Http\Controllers\Panel;

use Exception;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Cache\RedisTaggedCache;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Item\ItemStoreRequest;
use App\Http\Requests\Item\ItemUpdateRequest;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $items = Item::with('category')
                        ->latest()
                        ->get();

        return view('panel.items.index')->with('items', $items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $categories = Category::query()
                                ->orderBy("name")
                                ->get();

        return view('panel.items.create')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemStoreRequest $request)
    {
        try{
            $item = new Item();
            $item->name = $request->name;
            $item->description = $request->description;
            $item->price = $request->price;
            $item->stock = $request->stock;
            $item->category_id = $request->category_id;            

            //check optional image field
            if($request->file('image')){
                $image = base64_encode(file_get_contents($request->file('image')->path()));
                $item->image = $image;
            }

            $item->save();
            
            return redirect()->route('panel.items.index')->with('success', 'Item guardado correctamente!');
        }
        catch(Exception $e){
            return redirect()->back()->with('error', 'Ups! Error al guardar el item!');
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
            $item = Item::findOrFail($id);
            return view('panel.items.show')->with('item', $item);
        }
        catch(Exception $e){
            return redirect()->back()->with('error', 'Ups! Error al mostrar el item!');
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
            $item = Item::findOrFail($id);
            $categories = Category::query()
                                    ->latest()
                                    ->get();
                                    
            return view("panel.items.edit", ["item" => $item, "categories" => $categories]);
        }
        catch(Exception $e){
            return redirect()->back()->with('error', 'Ups! Error al editar el item'); 
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ItemUpdateRequest $request, $id)
    {
        try{
            $item = Item::findOrFail($id);

            $item->name = $request->name;
            $item->description = $request->description;
            $item->price = $request->price;
            $item->stock = $request->stock;
            $item->category_id = $request->category_id;

            //CheckBox for noImage
            if($request->noImage){
                $item->image = null;               
            }
            else{
                if($request->file('image')){
                    $image = base64_encode(file_get_contents($request->file('image')->path()));
                    $item->image = $image;
                }
            }

            $item->save();       
            
            return redirect()->route('panel.items.index')->with('success', 'Item editado correctamente!');
        }
        catch(Exception $e){
            return redirect()->back()->with('error', 'Ups! Error al editar el item');
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
            $item = Item::findOrFail($id);
            
            $item->delete();

            return redirect()->route('panel.items.index')->with('success', 'Item eliminado correctamente!');
        }
        catch(Exception $e){
            return redirect()->back()->with('error', 'Ups! Error al eliminar el item'); 
        }
    }
}
