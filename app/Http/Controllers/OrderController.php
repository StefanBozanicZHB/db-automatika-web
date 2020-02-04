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

/*
index - sluzi za prikaz svih podataka
show za prikaz pojedicnog zapisa iz tabele
*/
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $orders = Order::latest()->get();
            return Datatables::of($orders)
                ->addIndexColumn()
// podrazuvena se prosledjuju sve kolone iz tabele, preko toga mora da se dodaje rucna kao sto je u nastavku
// nova kolona pod nazivom client koja ce se koristiti na view u dataTable
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
                ->addColumn('type', function ($order) {
                    if ($order->type == 0) {
                        return 'USLUGA';
                    }
                    return 'LIČNO';
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

    public function create(Request $request)
    {

    }

    public function store(Request $request)
    {
        $year = date('Y', strtotime($request->date));
        $maxValue = Order::whereYear('date', $year)->orderBy('id', 'desc')->value('account_number');
        $maxValue++;
        Order::updateOrCreate(['id' => $request->order_id], [
            'date' => $request->date,
            'client_id' => $request->client_id,
            'account_number' => $maxValue,
            'total' => 0,00,
            'type' => $request->type
        ]);

        return response()->json(['success' => 'Saved successfully.']);
    }

//    show moze sa parametrima
    public function show(Request $request, $id)
    {
        $order = Order::find($id);
        $order_items = $order->orders_items;

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

// moze da se prenese ceo objekat, ali ovo je korisceno zbog testiranja
        return view("order.show")
            ->with('items', Item::all())
            ->with('order_id', $order->id)
            ->with("client", $order->client)
            ->with('total', $order->total)
            ->with("account_num", $acc)
            ->with("paid", $paid)
            ->with("date", $day .'.'.$mount.'.'.$year);
    }

    public function edit($id)
    {
        $order = Order::find($id);
        return response()->json($order);
    }

    public function update(Request $request, $id)
    {
        Order::updateOrCreate(['id' => $id], [
            'paid' => true,
        ]);

        return response()->json(['success' => 'Saved successfully.']);
    }

    public function destroy($id)
    {
        Order::find($id)->delete();
        return response()->json(['success' => 'Destroy successfully.']);
    }
}
