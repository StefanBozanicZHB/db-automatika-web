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
                    <div class="card-header">Pregled svih faktura
                        <a class="btn btn-success" style="float: right;" href="javascript:void(0)"
                           id="create_new">Nova faktura</a></div>
                    <table class="table table-striped data-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Klijent</th>
                            <th>Datum</th>
                            <th>Cena [RSD]</th>
                            <th>Plaćeno</th>
                            <th>Broj računa</th>
                            <th>Tip</th>
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
    <div class="modal fade" id="ajaxModalOrder" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 60%">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="orderForm" name="orderForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="order_id" id="order_id">

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Klijent</label>
                            <div class="col-sm-8">
                                <select id="client_id" name="client_id" class="form-control" required>
                                    <option value="">Izaberite klijenta</option>
                                    @foreach($clients as $client)
                                        <option value="{{$client['id']}}">{{$client['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <label class="col-sm-2 control-label">Tip fakture:</label>

                        <div class="form-group col-sm-8">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="service"
                                       name="type" checked value="0">
                                <label class="custom-control-label" for="service">Usluga</label>
                            </div>

                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="personally"
                                       name="type" value="1">
                                <label class="custom-control-label" for="personally">Lično</label>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="date" class="col-sm-2 control-label">Datum</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="date" name="date"
                                       value="<?php echo date('Y-m-d'); ?>" required="">
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
                    {data: 'date_formated', name: 'date_formated'},
                    // {data: 'date', name: 'date'},
                    {
                        data: 'total',
                        name: 'total',
                        className: 'dt-body-right',
                        render: $.fn.dataTable.render.number(',', '.', 2),
                    },
                    {data: 'paid', name: 'paid', className: 'dt-body-center'},
                    {data: 'account_num', name: 'account_num', className: 'dt-body-center'},
                    {data: 'type', name: 'type', className: 'dt-body-center'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $('#create_new').click(function () {
                $('#save_btn').show();
                $('#save_btn').val("create-order");
                $('#total').prop("readonly", false);
                $('#client_id').prop('disabled', false);
                $('#order_id').val('');
                $('#orderForm').trigger("reset");
                $('#modelHeading').html("Napravi novu faktutu");

                $('#ajaxModalOrder').modal('show');
            });

            $('#save_btn').click(function (e) {
                e.preventDefault();
                $(this).html('Slanje...');

                $.ajax({
                    data: $('#orderForm').serialize(),
                    url: "{{ route('orders.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {

                        $('#orderForm').trigger("reset");
                        $('#ajaxModalOrder').modal('hide');
                        table.draw();
                        $('#save_btn').html('Uspešno sačuvano');

                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#save_btn').html('Došlo je do greške, pokušakte ponovo');
                    }
                });
            });

            $('body').on('click', '#delete_order', function () {

                var order_id = $(this).data("id");
                if(confirm("Da li ste sigurni da želite da obrišete?")) {
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
                }
            });

        });

    </script>

@endsection

