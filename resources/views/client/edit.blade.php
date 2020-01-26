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
                            <li class="breadcrumb-item"><a href="{{route('home')}}" class="breadcrumb-link">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Promena klijenta</li>
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
                    <div class="card-header">{{ __('Promena klijenta') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('clients.update',$client) }}" aria-label="{{ __('Promena klijenta') }}">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Naziv') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{$client->name }}" required autofocus>
                                </div>
                            </div>

                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Grad') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="city" value="{{$client->city }}" required autofocus>
                                </div>
                            </div>

                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Adresa') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="address" value="{{$client->address }}" required autofocus>
                                </div>
                            </div>

                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Postanski broj') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="postal_code" value="{{$client->postal_code }}" required autofocus>
                                </div>
                            </div>

                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('PIB') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="pib_number" value="{{$client->pib_number }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Promeni') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <a class="btn-primary btn" href="{{route('clients.index')}}">Povratak na pregled</a>
                </div>
            </div>
        </div>
    </div>
@endsection


