<?php

namespace App\Http\Controllers;

use App\Client;
use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;

class OrderController extends Controller
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
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $orders = Order::latest()->get();
            return Datatables::of($orders)
                ->addIndexColumn()
                ->addColumn('client', function ($order) {
                    return $order->client->name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" id="show_order" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Show" class="edit btn btn-info btn-sm">Pregled</a> ';
                    $btn = $btn . ' <a href="javascript:void(0)" id="delete_order" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm ">Brisanje</a> ';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view("order.index")->with('clients', Client::all());
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        Order::updateOrCreate(['id' => $request->order_id], [
            'total' => $request->total,
            'client_id' => $request->client_id
        ]);

        return response()->json(['success' => 'City saved successfully.']);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //return view("order.show");


        try {
            $order = Order::with('user', 'items.item')->findOrFail($id);
            return view('orders.show', compact('order'));
        } catch (ModelNotFoundException $ex) {
            Flash::error('Model not found');
            return view('orders.index');
        }



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        return response()->json($order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
