@extends('main')

@section('pageheader')
    <!-- pageheader  -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">DB Automatika Pregled Racuna</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"
                                                           class="breadcrumb-link">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pregled Racuna</li>
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
                            <div>Klijent:
                                <label style="color:black; font-weight: bold;">{{$client->name}}</label>
                                @if($paid =='NEISPLACENO')
                                    <a class="btn btn-success" style="float: right;" href="javascript:void(0)"
                                       id="paid_button">Platio</a></div>
                            @endif
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
                        @if($paid =='NEISPLACENO')
                            <div class="title m-b-md" style="color:red; font-weight: bold;">
                                {{$paid}}
                            </div>
                        @else
                            <div class="title m-b-md" style="color:green; font-weight: bold;">
                                {{$paid}}
                            </div>
                        @endif

                        <div class="title m-b-md" style="color:green; font-weight: bold;">
                            Ukupno: {{number_format((float)$total, 2)}} RSD
                        </div>

                        <div style="margin: 5px 0px 60px 0px;">
                            <a class="btn btn-success" style="float: right;" href="javascript:void(0)"
                               id="create_new_order"> Nova stavka</a></div>
                    </div>

                    <table class="table table-striped data-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Stavka</th>
                            <th>Cena [RSD]</th>
                            <th>Kolicina</th>
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
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 60%">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="orderForm" name="orderForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="order_id" value="{{$order_id}}">

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Stavka</label>
                            <div class="col-sm-12">
                                <select id="item_id" name="item_id" class="form-control" required>
                                    <option value="">Izaberite stavku</option>
                                    @foreach($items as $item)
                                        <option value="{{$item['id']}}">{{$item['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="unit_price" class="col-sm-6 control-label">Kolicina</label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" id="quantity" name="quantity"
                                       placeholder="Kolicina" value="" maxlength="8" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="unit_price" class="col-sm-6 control-label">Cena po komadu</label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" id="unit_price" name="unit_price"
                                       placeholder="Cena po komadu" value="" maxlength="8" required="">
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Sacuvaj izmene
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ajaxModelPaid" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 60%">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="orderForm" name="orderForm" class="form-horizontal">
                        @csrf
                        {{--prenese se id--}}
                        <input type="hidden" name="order_id" id="order_id">

                        <label class="col-sm-2 control-label">{{$order_id}}</label>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Da li ste sigurni da je platio?</label>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="paidBtn" value="create">Platio
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ajaxModalEdit" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 60%">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="orderFormEdit" name="orderFormEdit" class="form-horizontal">
                        @csrf
                        {{--prenese se id--}}
                        <input type="hidden" name="order_item_id" id="order_item_id">

                        <div class="form-group">
                            <label for="unit_price" class="col-sm-6 control-label">Kolicina</label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" id="quantity_edit" name="quantity_edit"
                                       placeholder="Kolicina" value="" maxlength="8" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="unit_price" class="col-sm-6 control-label">Cena po komadu</label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" id="unit_price_edit" name="unit_price_edit"
                                       placeholder="Cena po komadu" value="" maxlength="8" required="">
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="editItemBtn" value="create">Platio
                            </button>
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
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'item', name: 'item'},
                    {
                        data: 'price', name: 'price',
                        className: 'dt-body-right',
                        render: $.fn.dataTable.render.number(',', '.', 2),
                    },
                    {data: 'quantity', name: 'quantity', className: 'dt-body-right'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $('#create_new_order').click(function () {
                $('#saveBtn').show();
                $('#total').prop("readonly", false);
                $('#client_id').prop('disabled', false);
                $('#saveBtn').val("create-order");
                $('#order_id').val('');
                $('#orderForm').trigger("reset");
                $('#modelHeading').html("Dodaj novu stavku za izvestaj");
                $('#ajaxModel').modal('show');
            });


            $('#paid_button').click(function () {
                $('#ajaxModelPaid').modal('show');
            });

            $('#paidBtn').click(function (e) {
                e.preventDefault();
                $(this).html('Slanje...');

                $.ajax({
                    data: $('#orderForm').serialize(),
                    url: "{{ route('orders.update', $order_id) }}",
                    type: "PUT",
                    dataType: 'json',
                    success: function (data) {

                        $('#orderForm').trigger("reset");
                        $('#ajaxModelPaid').modal('hide');
                        $('#saveBtn').html('Save Changes');
                        location.reload();

                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#saveBtn').html('Save Changes');
                    }
                });
            });

            $('body').on('click', '#edit_order_item', function () {
                var item_id = $(this).data('id');
                $.get("{{ route('order_items.index') }}" + '/' + item_id + '/edit', function (data) {
                    $('#modelHeading').html("Promena stavke");
                    $('#saveBtn').show();
                    $('#quantity_edit').prop("readonly", false);
                    $('#quantity_edit').val(data.quantity);
                    $('#unit_price_edit').prop("readonly", false);
                    $('#unit_price_edit').val(data.unit_price);
                    $('#ajaxModalEdit').modal('show');
                    $('#order_item_id').val(data.id);
                })
            });

            $('#editItemBtn').click(function (e) {
                e.preventDefault();
                $(this).html('Slanje...');
                var item_id = $('#order_item_id').val();
                // alert(test);
                $.ajax({
                    data: $('#orderFormEdit').serialize(),
                    url: "{{ route('order_items.index') }}"+ '/' + item_id ,
                    type: "PUT",
                    dataType: 'json',
                    success: function (data) {

                        $('#orderForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        // table.draw();
                        // $('#saveBtn').html('Save Changes');
                        location.reload();

                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#saveBtn').html('Save Changes');
                    }
                });
            });

            $('#saveBtn').click(function (e) {
                e.preventDefault();
                $(this).html('Slanje...');

                $.ajax({
                    data: $('#orderForm').serialize(),
                    url: "{{ route('order_items.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {

                        $('#orderForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        // table.draw();
                        // $('#saveBtn').html('Save Changes');
                        location.reload();

                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#saveBtn').html('Save Changes');
                    }
                });
            });

            $('body').on('click', '#delete_order', function () {

                var order_id = $(this).data("id");
                confirm("Are You sure want to delete order!");

                $.ajax({
                    type: "DELETE",
                    data: {"_token": "{{ csrf_token() }}"},
                    url: "order_items/" + order_id,
                    success: function (data) {
                        location.reload();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            });

        });

    </script>

@endsection

