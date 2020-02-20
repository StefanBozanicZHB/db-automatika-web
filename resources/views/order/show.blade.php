@extends('main')

@section('pageheader')
    <!-- pageheader  -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">DB Automatika Pregled Fakture</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"
                                                           class="breadcrumb-link">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{route('orders.index')}}"
                                                           class="breadcrumb-link">Pregled Evidencije</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pregled Fakture</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end pageheader  -->
@endsection
<div class="overlay"></div> {{--Zamucenje--}}
<div class="loader"></div> {{--Animacija ucitavanja--}}

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card" style="padding: 5px">
                    <div style="margin: 5px;">
                        <div class="title m-b-md">
                            <div>
                                Klijent:
                                <label style="color:black; font-weight: bold;">{{$client->name}}</label>

                                @if($paid =='NEISPLACENO')
                                    <a class="btn btn-success" style="float: right;" href="javascript:void(0)"
                                       id="paid_button">Platio</a>
                                @endif

                                <a class="btn btn-danger" style="float: right; margin-right: 20px" href="{{route('export_pdf', $order_id)}}"
                                   id="pdf_button">PDF</a>

                            </div>
                        </div>
                        <div>
                            PIB: <label style="color:black; font-weight: bold;">{{$client->pib_number}}</label>
                        </div>
                        <div>
                            Adresa: <label style="color:black; font-weight: bold;">{{$client->address}}
                                , {{$client->city}}</label>
                        </div>
                        <hr>
                        <div class="title m-b-md">
                            Datum:
                            <label style="color:black; font-weight: bold;">{{$date}}</label>
                        </div>
                        <div class="title m-b-md">
                            Broj racuna: <label style="color:black; font-weight: bold;">{{$account_num}}</label>
                        </div>

                        <div class="title m-b-md">
                            Vrsta:
                            @if($type == 0)
                                <label style="color:black; font-weight: bold;">USLUŽNO</label>
                            @else
                                <label style="color:black; font-weight: bold;">LIČNO</label>
                            @endif
                        </div>

                        @if($paid =='NEISPLACENO')
                            <div class="title m-b-md" style="color:red; font-weight: bold;">
                                NEISPLAĆENO
                            </div>
                        @else
                            <div class="title m-b-md" style="color:green; font-weight: bold;">
                                PLAĆENO
                            </div>
                        @endif

                        <div class="title m-b-md" style="color:green; font-weight: bold; margin-bottom: 20px">
                            Ukupno: {{number_format((float)$total, 2)}} RSD
                        </div>

                        @if($paid == 'NEISPLACENO')
                            <div style="margin: 5px 0px 60px 0px;">
                                <a class="btn btn-success" style="float: right;" href="javascript:void(0)"
                                   id="create_new_order_item">Nova stavka</a></div>
                        @endif


                    </div>

                    <table class="table table-striped data-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Stavka</th>
                            <th>Cena [RSD]</th>
                            <th>Količina</th>
                            <th>Ukupno</th>
                            <th>Akcija</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    {{--    modal za dodavanje nove stavke--}}
    {{--    najbitnije je name da formu csrf, id je bitan za promeni komponente--}}
    <div class="modal fade" id="ajax_modal_new_order_item" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 60%">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Dodavanje nove stavke</h4>
                </div>
                <div class="modal-body">
                    <form id="form_new_order_item" name="form_new_order_item" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="order_id" value="{{$order_id}}">

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Stavka</label>
                            <div class="col-sm-12 row">
                                <div class="col-md-11">
                                    <select id="item_id" name="item_id" class="form-control " required>
                                        <option value="">Izaberite stavku</option>
                                        @foreach($items as $item)
                                            <option value="{{$item['id']}}">{{$item['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <a class="btn btn-primary" style="float: right;" id="create_new_item_btn">+
                                    </a>
                                </div>


                            </div>

                        </div>

                        <div class="form-group">
                            <label for="unit_price" class="col-sm-6 control-label">Količina</label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" id="quantity" name="quantity"
                                       placeholder="Količina" value="" maxlength="8" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="unit_price" class="col-sm-6 control-label">Cena po komadu u dinarima</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="unit_price" name="unit_price"
                                       placeholder="RSD" value="" maxlength="8" required="">
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="save_btn" value="create">Sačuvaj izmene
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{--    placeno znaci da se samo menja jedno polje u bazi--}}
    <div class="modal fade" id="ajax_modal_paid" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 60%">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">DB Automatika</h4>
                </div>
                <div class="modal-body">
                    {{--bitan je id za form kada se kasnije prosledjuje Controlleru--}}
                    <form id="form_paid" name="form_paid" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="order_id" id="order_id">

                        <div class="form-group">
                            <label class="col-sm-10 control-label">Da li ste sigurni da je plaćeno?</label>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="paid_btn" value="create">Plaćeno je
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ajax_modal_edit_item" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 60%">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Promena stavke</h4>
                </div>
                <div class="modal-body">
                    <form id="form_edit_item" name="form_edit_item" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="order_item_id" id="order_item_id">

                        <div class="form-group">
                            <label for="unit_price" class="col-sm-6 control-label">Količina</label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" id="quantity_edit" name="quantity_edit"
                                       placeholder="Količina" value="" maxlength="8" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="unit_price" class="col-sm-6 control-label">Cena po komadu u dinarima</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="unit_price_edit" name="unit_price_edit"
                                       placeholder="Cena po komadu" value="" maxlength="8" required="">
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="edit_item_btn" value="create">Sačuvaj
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ajax_modal_new_item" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 60%">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Nova stavka</h4>
                </div>
                <div class="modal-body">
                    <form id="form_new_item" name="form_new_item" class="form-horizontal">
                        @csrf

                        <div class="form-group">
                            <label for="unit_price" class="col-sm-6 control-label">Naziv</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name"
                                       placeholder="Unesite naziv stavke" required>
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-12">
                            <a class="btn btn-primary" id="test_btn" style="float: right" value="create">Sačuvaj
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function () {
            var table = $('.data-table').DataTable({
                language: {
                    "processing": '<i class="fa fa-spinner fa-spin fa-4x fa-fw"></i> ',
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('orders.show',$order_id) }}",
                columns: [
                    // ovde se definisu kolone za tabelu koje se dobije iz Controllera
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'item', name: 'item'},
                    {
                        data: 'price',
                        name: 'price',
                        className: 'dt-body-right',
                        render: $.fn.dataTable.render.number(',', '.', 2),
                    },
                    {data: 'quantity', name: 'quantity', className: 'dt-body-right'},
                    {
                        data: 'total_item',
                        name: 'total_item',
                        className: 'dt-body-right',
                        render: $.fn.dataTable.render.number(',', '.', 2),
                    },
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $('#create_new_order_item').click(function () {
                $('#ajax_modal_new_order_item').modal('show');
            });


            $('#paid_button').click(function () {
                $('#ajax_modal_paid').modal('show');
            });

            $('#create_new_item_btn').click(function () {
                $('#ajax_modal_new_order_item').modal('hide');
                $('#ajax_modal_new_item').modal('show');
            });

            $('#test_btn').click(function () {
                if ($('#name').val() != '') {
                    $(this).html('Slanje...');
                    $.ajax({
                        data: $('#form_new_item').serialize(),
                        url: "../items",
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {

                            $.get("{{ url('api/get_items')}}",
                                function (data) {
                                    var item_id = $('#item_id');
                                    item_id.empty();
                                    // item_id.append("<option value=''>Odaberi stavku</option>");

                                    $.each(data, function (key, value) {

                                        item_id.append($("<option></option>")
                                            .attr("value", key)
                                            .text(value));
                                    });

                                }
                            );

                            $('#ajax_modal_new_item').modal('hide');
                            $('#ajax_modal_new_order_item').modal('show');
                        },
                        error: function (data) {
                            console.log('Error:', data);
                            $('#saveBtn').html('Sacuvaj promene');
                        }
                    });

                }
                else {
                    alert('Nije popunjeno polje za naziv stavke');
                }
            });

            $('#paid_btn').click(function (e) {
                e.preventDefault();
                $(this).html('Slanje mejla u toku...');

                $.ajax({
                    // podaci iz forme koje gore prethodno predefinisana
                    data: $('#form_paid').serialize(),
                    url: "{{ route('orders.update', $order_id) }}",
                    type: "PUT",
                    dataType: 'json',
                    success: function (data) {
                        $('#form_paid').trigger("reset");
                        location.reload();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#save_btn').html('Desila se greška, pokušajte ponovo');
                    }
                });
            });

            $('body').on('click', '#edit_order_item', function () {
                var item_id = $(this).data('id');
                $.get("{{ route('order_items.index') }}" + '/' + item_id + '/edit', function (data) {
                    $('#quantity_edit').prop("readonly", false);
                    $('#quantity_edit').val(data.quantity);
                    $('#unit_price_edit').prop("readonly", false);
                    $('#unit_price_edit').val(data.unit_price);
                    $('#ajax_modal_edit_item').modal('show');
                    $('#order_item_id').val(data.id);
                })
            });

            $('#edit_item_btn').click(function (e) {
                e.preventDefault();
                $(this).html('Slanje...');
                var item_id = $('#order_item_id').val();
                $.ajax({
                    data: $('#form_edit_item').serialize(),
                    url: "{{ route('order_items.index') }}" + '/' + item_id,
                    type: "PUT",
                    dataType: 'json',
                    success: function (data) {
                        $('#form_edit_item').trigger("reset");
                        location.reload();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#save_btn').html('Greška, pokulajte ponovo');
                    }
                });
            });

            $('#save_btn').click(function (e) {
                e.preventDefault();
                $(this).html('Slanje...');

                $.ajax({
                    data: $('#form_new_order_item').serialize(),
                    url: "{{ route('order_items.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#form_new_order_item').trigger("reset");
                        location.reload();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#save_btn').html('Greška, pokušajte ponovo');
                    }
                });
            });

            $('body').on('click', '#delete_order', function () {
                var id = $(this).data("id");
                if (confirm("Da li ste sigurni da želite da obrišete?")) {
                    $.ajax({
                        type: "DELETE",
                        data: {"_token": "{{ csrf_token() }}"},
                        url: "../order_items/" + id,
                        success: function (data) {
                            location.reload();
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
            });

            // vidljiv samo ako je placeno

            var data = '<?php echo json_encode($paid); ?>';
            if (data == '"PLACENO"') {
                table.columns([5, 5]).visible(false);
            }

        });

    </script>

@endsection

