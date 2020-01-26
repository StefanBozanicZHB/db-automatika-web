@extends('main')

@section('pageheader')
    <!-- pageheader  -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">DB Automatika Evidencija</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"
                                                           class="breadcrumb-link">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pregled Evidencije</li>
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
                    <div class="card-header">Evidencija index
                        <a class="btn btn-success" style="float: right;" href="javascript:void(0)"
                           id="create_new_order"> Novi nalog</a></div>
                    <table class="table table-striped data-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Klijent</th>
                            <th>Datum</th>
                            <th>Cena</th>
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
                        {{--prenese se id--}}
                        <input type="hidden" name="order_id" id="order_id">

                        <div class="form-group">
                            <label for="total" class="col-sm-2 control-label">Cena</label>
                            <div class="col-sm-2">
                                {{--mora da se promeni i id i name--}}
                                <input type="text" class="form-control" id="total" name="total"
                                       placeholder="Enter Total" value="" maxlength="50" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Detalji</label>
                            <div class="col-sm-12">
                                <select id="client_id" name="client_id" class="form-control" required>
                                    <option value="">izaberite klijenta</option>
                                    @foreach($clients as $client)
                                        <option value="{{$client['id']}}">{{$client['name']}}</option>
                                    @endforeach
                                </select>
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
                ajax: "{{ route('orders.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'client', name: 'client'},
                    {data: 'date', name: 'date'},
                    {data: 'total', name: 'total'},
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
                $('#modelHeading').html("Kreiraj novi izvestaj");
                $('#ajaxModel').modal('show');
            });

            $('body').on('click', '#show_order1', function () {
                var order_id = $(this).data('id');
                $.get("{{ route('orders.index') }}" + '/' + order_id + '/edit', function (data) {
                $('#modelHeading').html("Show Order");
                $('#saveBtn').val("edit-order");
                $('#ajaxModel').modal('show');
                $('#order_id').val(data.id);
                $('#total').val(data.total);
                $('#total').prop("readonly", true);
                $('#client_id').val(data.client_id);
                $('#client_id').prop('disabled', 'disabled');
                $('#saveBtn').hide()
                })
            });

            $('body').on('click', '#show_order', function () {
                var order_id = $(this).data('id');
                $.get("{{ route('orders.show') }}" + '/' + order_id, function (data) {
                    $('#modelHeading').html("Show Order");
                    $('#saveBtn').val("edit-order");
                    $('#ajaxModel').modal('show');
                    $('#order_id').val(data.id);
                    $('#total').val(data.total);
                    $('#total').prop("readonly", true);
                    $('#client_id').val(data.client_id);
                    $('#client_id').prop('disabled', 'disabled');
                    $('#saveBtn').hide()
                })
            });



            $('#saveBtn').click(function (e) {
                e.preventDefault();
                $(this).html('Slanje...');

                $.ajax({
                    data: $('#orderForm').serialize(),
                    url: "{{ route('orders.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {

                        $('#orderForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        table.draw();
                        $('#saveBtn').html('Save Changes');

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
                    url: "orders/" + order_id,
                    success: function (data) {
                        table.draw();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            });

        });

    </script>

@endsection

