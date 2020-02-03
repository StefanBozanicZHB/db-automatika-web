<?php

namespace App\Http\Controllers;

use App\Client;
use App\Item;
use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;

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
                ->addColumn('account_num', function ($order) {
                    $acc = $order->account_number;
                    if (strlen($acc) == 1) {
                        $acc = '0' . $acc;
                    }
                    $acc = $acc . '/';
                    $year = date('Y', strtotime($order->date));
                    $acc = $acc . $year;
                    return $acc;
                })
                ->addColumn('date_formated', function ($order) {
                    $year = date('Y', strtotime($order->date));
                    $mounth = date('m', strtotime($order->date));
                    $day = date('d', strtotime($order->date));

                    $date_full = $year . '.' . $mounth . '.' . $day . '.';
                    return $date_full;
                })
                ->addColumn('paid', function ($order) {
                    if ($order->paid) {
                        return 'DA';
                    }
                    return 'NE';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="orders/' . $row->id . '"  id="show_order" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Show" class="edit btn btn-info btn-sm">Pregled</a> ';
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
    public function create(Request $request)
    {

    }

    public function paid($id)
    {
        dd($id);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $year = date('Y', strtotime($request->date));
        $maxValue = Order::whereYear('date', $year)->orderBy('id', 'desc')->value('account_number');
        $maxValue++;
        Order::updateOrCreate(['id' => $request->order_id], [
            'date' => $request->date,
            'client_id' => $request->client_id,
            'account_number' => $maxValue,
            'total' => 0,00
        ]);

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
        $order = Order::find($id);

        $order_items = $order->orders_items;
//        dd($order_items);
        if ($request->ajax()) {
            $order = Order::find($id);
            $order_items = $order->orders_items;
            return Datatables::of($order_items)
                ->addIndexColumn()
                ->addColumn('item', function ($order_items) {
                    return $order_items->item->name;
                })
                ->addColumn('price', function ($order_items) {
                    return $order_items->unit_price;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" id="edit_order_item" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Show" class="edit btn btn-info btn-sm">Izmeni</a> ';
                    $btn = $btn . ' <a href="javascript:void(0)" id="delete_order" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm ">Brisanje</a> ';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $acc = $order->account_number;
        if (strlen($acc) == 1) {
            $acc = '0' . $acc;
        }
        $acc = $acc . '/';
        $year = date('Y', strtotime($order->date));
        $mount = date('m', strtotime($order->date));
        $day = date('d', strtotime($order->date));
        $acc = $acc . $year;

        $paid = 'NEISPLACENO';
        if($order->paid){
            $paid = 'PLACENO';
        }

        return view("order.show")
            ->with('items', Item::all())
            ->with('order_id', $order->id)
            ->with("client", $order->client)
            ->with('total', $order->total)
            ->with("account_num", $acc)
            ->with("paid", $paid)
            ->with("date", $day .'.'.$mount.'.'.$year);
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
        Order::updateOrCreate(['id' => $id], [
            'paid' => true,
        ]);

        return response()->json(['success' => 'Stavka uspesno sacuvana.']);
//        return redirect()->route('orders.index', ['id' => $id]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Order::find($id)->delete();
        return response()->json(['success' => 'Racun uspesno obrisan.']);
    }
}
