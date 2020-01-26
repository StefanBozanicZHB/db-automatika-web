@extends('main')

@section('pageheader')
    <!-- pageheader  -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">DB Automatika Stavke</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"
                                                           class="breadcrumb-link">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pregled Stavki</li>
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
                    <div class="card-header">Pregled Stavki
                        <a class="btn btn-success" style="float: right;" href="javascript:void(0)"
                           id="create_new_item">Nova stavka</a></div>
                    <table class="table table-striped data-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Naziv</th>
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
                    <form id="itemForm" name="itemForm" class="form-horizontal">
                        @csrf
                        {{--prenese se id--}}
                        <input type="hidden" name="item_id" id="item_id">

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Naziv</label>
                            <div class="col-sm-12">
                                {{--mora da se promeni i id i name--}}
                                <input type="text" class="form-control" id="name" name="name"
                                       placeholder="Unos naziva" value="" maxlength="50" required="">
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
                ajax: "{{ route('items.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]

            });

            $('#create_new_item').click(function () {
                $('#saveBtn').show();
                $('#name').prop("readonly", false);
                $('#saveBtn').val("create-item");
                $('#item_id').val('');
                $('#itemForm').trigger("reset");
                $('#modelHeading').html("Kreiraj novu stavku");
                $('#ajaxModel').modal('show');
            });

            $('body').on('click', '#edit_item', function () {
                var item_id = $(this).data('id');
                $.get("{{ route('items.index') }}" + '/' + item_id + '/edit', function (data) {
                    $('#modelHeading').html("Promena stavke");
                    $('#saveBtn').show();
                    $('#name').prop("readonly", false);
                    $('#name').val(data.name);
                    $('#saveBtn').val("edit-item");
                    $('#ajaxModel').modal('show');
                    $('#item_id').val(data.id);
                })
            });

            $('#saveBtn').click(function (e) {
                e.preventDefault();
                $(this).html('Slanje..');

                $.ajax({

                    data: $('#itemForm').serialize(),
                    url: "{{ route('items.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {

                        $('#itemForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        table.draw();
                        $('#saveBtn').html('Sacuvaj promene');

                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#saveBtn').html('Sacuvaj promene');
                    }
                });
            });

            $('body').on('click', '#delete_item', function () {

                var item_id = $(this).data("id");
                confirm("Da li ste sigurni da zelite da obrisete stavku!");

                $.ajax({
                    type: "DELETE",
                    data: {"_token": "{{ csrf_token() }}"},
                    url: "items/" + item_id,
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

