<?php

namespace App\Http\Controllers;

use App\Item;
use App\Order;
use App\Order_item;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class OrderItemController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $order_item = new Order_item();
        $order_item->order_id = $request->order_id;
        $order_item->item_id = $request->item_id;
        $order_item->unit_price = $request->unit_price;
        $order_item->quantity = $request->quantity;

        $order_item->save();

        $order = Order::find($request->order_id);
        $order->total += $request->unit_price * $request->quantity;
        $order->update();

        return response()->json(['success' => 'City saved successfully.']);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Order_item::find($id);
        return response()->json($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $order_item = Order_item::find($request->order_item_id);

        $current_price = $order_item->unit_price * $order_item->quantity;
        $new_price = $request->unit_price_edit * $request->quantity_edit;

        $order_item->unit_price = $request->unit_price_edit;
        $order_item->quantity = $request->quantity_edit;

        $order_item->save();

        $order = $order_item->order;
        $order->total = $order->total - $current_price + $new_price;
        $order->update();

        return response()->json(['success' => 'City saved successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order_item = Order_item::find($id);
        dd($order_item);
        $current_price = $order_item->unit_price * $order_item->quantity;

        $order = $order_item->order;
        $order->total -= $current_price;
        $order->update();


        $order_item->delete();

        return response()->json(['success' => 'Racun uspesno obrisan.']);
    }
}
