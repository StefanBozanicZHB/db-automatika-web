<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Item;

class ItemController extends Controller
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
            $items = Item::latest()->get();               // ovo je primarno sta se salje, glavna tabela
            return Datatables::of($items)
                ->addIndexColumn()                  // dodaju se normalne tabele iz tabele, ne moraju van ovaga se dodaje
                ->addColumn('action', function ($row) {         // dodavanje akcija, bitno je id za dugme (show_order...)
                    $btn = '<a href="javascript:void(0)" id="edit_item" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm">Promena</a> ';
                    $btn = $btn . ' <a href="javascript:void(0)" id="delete_item" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm ">Brisanje</a> ';

                    return $btn;
                })
                ->rawColumns(['action'])                // akcija
                ->make(true);
        }

        return view("item.index"); // prosledi na pogled sa tabelom sa prenesenim kljucem
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd('test');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Item::updateOrCreate(['id' => $request->item_id], [
            'name' => $request->name,
        ]);

        return response()->json(['success' => 'Stavka uspesno sacuvana.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::find($id);
        return response()->json($item);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Item::find($id)->delete();
        return response()->json(['success' => 'Racun uspesno obrisan.']);
    }

    public function get_items()
    {
        $items = Item::orderBy('name', 'asc')->get()->pluck('name','id');
        return response()->json($items);
    }
}
