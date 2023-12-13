@extends('layout.layout')

@section('managebrandbutton', 'active submenu')
@section('showmanagebrand', 'show')
@section('newbrand', 'active')

@section('content')
    <div class="main-panel">
        <div class="content">
            {{-- ini page buat add new brands --}}
            <div class="page-inner">
                <div class="page-header">
                    <h4 class="page-title">Tambah Brand Baru</h4>
                    <ul class="breadcrumbs">
                        <li class="nav-home">
                            <i class="flaticon-home"></i>
                        </li>
                        <li class="separator">
                            <i class="flaticon-right-arrow"></i>
                        </li>
                        <li class="separator">
                            <a>Kelola Brand</a>
                        </li>
                        <li class="separator">
                            <i class="flaticon-right-arrow"></i>
                        </li>
                        <li class="separator">
                            <a>Tambah Brand Baru</a>
                        </li>
                    </ul>
                </div>
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
                                    <div class="card-title">Tambah Data Brand Baru</div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="customeridforbrand">Pemilik Brand<span style="color: red"> (harus dipilih)
                                        </span></label>
                                        <select class="form-control" id="customeridforbrand" name="customeridforbrand" data-width="100%">
                                            <option></option>
                                            @foreach ($customer as $cust)
                                                {{-- <option value="{{ $cust->customer_id }}">{{ $cust->customer_name }}</option> --}}
                                                <option value="{{ $cust->customer_id }}">{{ $cust->customer_name }}</option>
                                                {{-- ^ini diatas diganti ke id yang auto increment di tabel customer soalnya fk ga tau knp selalu constraintnya bigint, ga bisa string --}}
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="largeInput">ID Brand<span style="color: red"> (harus diisi)
                                        </span></label>
                                        <input type="text" class="form-control form-control" placeholder="contoh: BD001"
                                            id="brandid" name="brandid">
                                    </div>
                                    <div class="form-group">
                                        <label for="largeInput">Nama Brand<span style="color: red"> (harus diisi)
                                        </span></label>
                                        <input type="text" class="form-control form-control" placeholder="contoh: Nestle"
                                            id="brandname" name="brandname">
                                    </div>
                                    <div class="form-group">
                                        <div class="card mt-4">
                                            <button class="btn btn-success"><strong>Tambah Brand Baru</strong></button>
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
