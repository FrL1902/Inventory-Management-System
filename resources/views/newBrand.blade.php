@extends('layout.layout')

@section('managebrandbutton', 'active')
@section('showmanagebrand', 'show')
@section('newbrand', 'active')

@section('content')
    <div class="main-panel">
        <div class="content">
            ini page buat add new brands
            <div class="page-inner">

                @if (session('sukses_addNewBrand'))
                    <div class="alert alert-success alert-block" id="alertSuccess">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ session('sukses_addNewBrand') }}</strong>
                    </div>
                @elseif ($errors->any())
                    <div class="alert alert-danger alert-block" id="alertFailed">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Data Gagal Dimasukkan: {{ $errors->first() }}</strong>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <form action="/makeBrand" method="post">
                                @csrf
                                <div class="card-header">
                                    <div class="card-title"><strong>Masukkan Brand Baru</strong></div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="customeridforbrand">Pemilik Brand</label>
                                        <select class="form-control" id="customeridforbrand" name="customeridforbrand">
                                            @foreach ($customer as $cust)
                                                {{-- <option value="{{ $cust->customer_id }}">{{ $cust->customer_name }}</option> --}}
                                                <option value="{{ $cust->id }}">{{ $cust->customer_name }}</option>
                                                {{-- ^ini diatas diganti ke id yang auto increment di tabel customer soalnya fk ga tau knp selalu constraintnya bigint, ga bisa string --}}
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="largeInput">ID Brand</label>
                                        <input type="text" class="form-control form-control" placeholder="contoh: BD001"
                                            id="brandid" name="brandid">
                                    </div>
                                    <div class="form-group">
                                        <label for="largeInput">Nama Brand</label>
                                        <input type="text" class="form-control form-control" placeholder="contoh: Nestle"
                                            id="brandname" name="brandname">
                                    </div>
                                    <div class="form-group">
                                        <div class="card mt-4">
                                            <button class="btn btn-success"><strong>Buat Brand Baru</strong></button>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="card-action">
                                    <button class="btn btn-success">Submit</button>
                                </div> --}}
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
