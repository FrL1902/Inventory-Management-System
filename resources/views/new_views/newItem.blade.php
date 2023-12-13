@extends('layout.layout')

@section('content')

@section('manageitembutton', 'active submenu')
@section('newitem', 'active')
@section('showmanageitem', 'show')

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Tambah Barang Baru</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <i class="flaticon-home"></i>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="separator">
                        <a>Kelola Barang</a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="separator">
                        <a>Tambah Barang Baru</a>
                    </li>
                </ul>
            </div>
            @if (session('sukses_addNewItem'))
                <div class="alert alert-success alert-block" id="alertSuccess">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Barang "{{ session('sukses_addNewItem') }}" berhasil dimasukkan</strong>
                </div>
            @elseif (session('no_item_incoming'))
                <div class="alert alert-danger alert-block" id="alertFailed">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ session('no_item_incoming') }}</strong>
                </div>
            @elseif (session('no_item_outgoing'))
                <div class="alert alert-danger alert-block" id="alertFailed">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ session('no_item_outgoing') }}</strong>
                </div>
            @elseif ($errors->any())
                <div class="alert alert-danger alert-block" id="alertFailed">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Data gagal dimasukkan: {{ $errors->first() }}</strong>
                </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <form enctype="multipart/form-data" method="post" action="/makeItem">
                            @csrf
                            <div class="card-header">
                                <div class="card-title">Tambah Data Barang Baru</div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="brandidforitem">Brand Pemilik Barang<span style="color: red"> (harus
                                            dipilih)
                                        </span></label>
                                    <select class="form-control" id="brandidforitem" name="brandidforitem"
                                        data-width="100%">
                                        <option></option>
                                        @foreach ($brand as $brand)
                                            <option value="{{ $brand->brand_id }}">{{ $brand->brand_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="largeInput">ID Barang<span style="color: red"> (harus diisi)
                                        </span></label>
                                    <input type="text" class="form-control form-control" placeholder="Contoh: AA001"
                                        id="itemid" name="itemid">
                                </div>
                                <div class="form-group">
                                    <label for="largeInput">Nama Barang<span style="color: red"> (harus diisi)
                                        </span></label>
                                    <input type="text" class="form-control form-control"
                                        placeholder="Contoh: Motor Vario" id="itemname" name="itemname">
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Stok Utama Barang </label><a class="ml-3 mb-2"
                                        style="cursor: pointer">
                                        <i class="fa fa-question-circle text-primary" data-toggle="tooltip"
                                            data-original-title="Stok barang yang sudah ada sekarang. Jika tidak diisi akan menjadi 0"></i>
                                    </a>
                                    <input type="number" id="quantity" name="itemStock" min="0" max="999999999"
                                        style="width: 200px" class="form-control" placeholder="0 - 999999999">
                                </div>
                                <div class="form-group">
                                    <label for="largeInput">Foto Barang<span style="color: red"> (harus diisi dan harus
                                            dibawah 10MB)
                                        </span></label>
                                    <input type="file" class="form-control form-control" id="itemImage"
                                        name="itemImage">
                                </div>
                                <div class="form-group">
                                    <div class="card mt-4">
                                        <button class="btn btn-success"
                                            onclick="document.getElementById('itemAdd').style.display='inline-block'; document.getElementById('overlayPage').style.display='block';">
                                            {{-- <button id="buttonItem" class="btn btn-success"> --}}
                                            <strong>Tambah Barang Baru</strong>
                                            <i id="itemAdd" style="display:none"
                                                class="loading-icon fa fa-spinner fa-spin" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
