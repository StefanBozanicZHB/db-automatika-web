@extends('main')

@section('pageheader')
    <!-- pageheader  -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">Smart Kiosk Dashboard </h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}" class="breadcrumb-link">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Kreiranje klijenta</li>
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
                    <div class="card-header">{{ __('Kreiraj novog klijenta') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('clients.store') }}" aria-label="{{ __('Create new country') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Naziv') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Adresa') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="address" value="{{ old('address') }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Grad') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="city" value="{{ old('city') }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Postanski broj') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="postal_code" value="{{ old('postal_code') }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('PIB') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="pib_number" value="{{ old('pib_number') }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('OK') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <a class="btn-primary btn" href="{{route('clients.index')}}">Povracaj na pregled klijenata</a>
                </div>
            </div>
        </div>
    </div>
@endsection
