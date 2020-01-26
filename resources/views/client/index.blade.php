@extends('main')

@section('pageheader')
    <!-- pageheader  -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">DB Automatika Dashboard</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Countries list</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end pageheader  -->
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Klijenti</div>

                    <table  id="user_index" class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Naziv</th>
                            <th scope="col">PIB</th>
                            <th style="text-align: center" scope="col" colspan="3">Akcije</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $clients as $client)
                            <tr>
                                <th scope="row"> {{$client->id}}</th>
                                <td>{{$client->name}}</td>
                                <td>{{$client->pib_number}}</td>
                                <td><a class="btn btn-primary" href="{{route('clients.show',$client)}}">Pregled</a></td>
                                <td><a class="btn btn-warning" href="{{route('clients.edit',$client)}}">Promena</a></td>
                                <td>
                                    <form action="{{ route('clients.destroy',$client) }}" method="POST"  onsubmit="return confirm('Da li ste sigurni da zelite da obrisete klijenta?');">
                                        @csrf
                                        <input type="hidden" name="_method" value="delete">
                                        <button class="btn btn-danger" type="submit">Brisanje</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $clients->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
