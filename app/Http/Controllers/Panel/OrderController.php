<?php

namespace App\Http\Controllers\Panel;

use Exception;
use App\Models\Item;
use App\Models\Role;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Facade\Ignition\QueryRecorder\Query;
use App\Http\Requests\Order\OrderStoreRequest;
use App\Http\Requests\Order\OrderAddItemRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::query()
                            ->latest()
                            ->get();

        //dd($orders);
        return view('panel.orders.index')->with('orders', $orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $waiters = User::where('role_id', Role::MOZO)->get();
        return view('panel.orders.create')->with(['waiters' => $waiters]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderStoreRequest $request)
    {
        try{
            $order = new Order();
            $order->user_id = $request->user_id;
            $order->closed = $request->closed;
            $order->description = $request->description;
            
            $order->save();
            
            return redirect()->route('panel.orders.show', ['id' => $order->id])->with('success', 'Orden guardada correctamente!');
        }
        catch(Exception $e){
            return redirect()->back()->with('error', 'Ups! Error al guardar la orden!');
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
            $order = Order::findOrFail($id);
            
            //solo los items que no estan en la orden (para evitar duplicados)
            $items_id = $order->items->pluck('id')->toArray();
            $items = Item::whereNotIn('id', $items_id)->where('stock','>',0)->get();

            $total = 0;
            foreach ($order->items as $item) {
                 $total += $item->price * $item->pivot->quantity;
            }

            return view('panel.orders.show')->with([
                'order' => $order, 
                'items' => $items, 
                'total' => $total,                
                ]);
        }
        catch(Exception $e){
            dd($e->getMessage());
            return redirect()->back()->with('error', 'Ups! Error al mostrar la orden!');
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
        //Si el usuario carga mal una orden, la elimina y la carga nuevamente.
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

    public function addItem(OrderAddItemRequest $request, $id)
    {
        try{
            $order = Order::findOrFail($id);
            
            //checkeo que exista el stock de ese item
            $itemToAdd = Item::findOrFail($request->item_id);
            if ($itemToAdd->stock < $request->quantity){
                return redirect()->back()->with('error', 'No hay stock suficiente!');                
            }

            $itemToAdd->stock = $itemToAdd->stock - $request->quantity; 
            $itemToAdd->save();               
            $order->items()->attach($request->item_id, ['quantity' => $request->quantity]);

            return redirect()->back();
        }
        catch(Exception $e){
            return redirect()->back()->with('error', 'Ups! Error al editar la orden');
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
            $order = Order::findOrFail($id);            
            $order->delete();

            return redirect()->route('panel.orders.index')->with('success', 'Orden eliminada correctamente!');
        }
        catch(Exception $e){
            return redirect()->back()->with('error', 'Ups! Error al eliminar la orden'); 
        }
    }

    /*
     * Remove the specified item from the order
    */
    public function destroyItem($id, $item_id)
    {
        try{
            $order = Order::findOrFail($id);

            //recupero los ids de los items asociados a la orden
            $items = $order->items()->get();
            //recupero el item 
            $itemToAddStock = $items->find($item_id);
            //incremento el stock restado
            $itemToAddStock->stock += $itemToAddStock->pivot->quantity;            
            $itemToAddStock->save();

            //saco el item de la orden
            $order->items()->detach($item_id);

            return redirect()->back()->with('success', 'Item eliminado de la orden correctamente!');
        }
        catch(Exception $e){
            return redirect()->back()->with('error', 'Ups! Error al borrar el item de la orden');
        }
    }

    public function close($id)
    {
        try{
            $order = Order::findOrFail($id);            
            $order->closed = 1;
            $order->save();

            return redirect()->Route('panel.orders.index')->with('success', 'Orden cerrada correctamente!');
        }
        catch(Exception $e){
            return redirect()->back()->with('error', 'Ups! Error al cerrar la orden'); 
        }
    }

}
