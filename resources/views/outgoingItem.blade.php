@extends('layout.layout')

@section('manageitembutton', 'active submenu')
@section('newoutgoing', 'active')
{{-- ganti yang atas ini aja --}}
@section('showmanageitem', 'show')

@section('content')
    <div class="main-panel">
        <div class="content">
            {{-- tes template, outgoing --}}
            <div class="page-inner">
                <div class="page-header">
                    <h4 class="page-title">Barang Keluar</h4>
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
                            <a>Barang Keluar</a>
                        </li>
                    </ul>
                </div>

                {{-- error goes here --}}
                @if (session('suksesDeleteOutgoing'))
                    <div class="alert alert-warning alert-block" id="alertDelete">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ session('suksesDeleteOutgoing') }}</strong>
                    </div>
                @elseif (session('suksesUpdateOutgoing'))
                    <div class="alert alert-success alert-block" id="alertSuccess">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ session('suksesUpdateOutgoing') }}</strong>
                    </div>
                @elseif (session('newValueMinus'))
                    <div class="alert alert-danger alert-block" id="alertFailed">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Data Gagal Diupdate: {{ session('newValueMinus') }}</strong>
                    </div>
                @elseif (session('noData_editItem'))
                    <div class="alert alert-danger alert-block" id="alertFailed">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Gagal: Tidak ada data yang dimasukkan</strong>
                    </div>
                @elseif (session('gagalReduceValue'))
                    <div class="alert alert-danger alert-block" id="alertFailed">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Gagal melakukan pengeluaran barang "{{ session('gagalReduceValue') }}": Jumlah barang
                            keluar lebih besar dari jumlah stok yang ada</strong>
                    </div>
                @elseif (session('sukses_reduceStock'))
                    <div class="alert alert-success alert-block" id="alertSuccess">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Sukses mengeluarkan stok "{{ session('sukses_reduceStock') }}"</strong>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger alert-block" id="alertFailed">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Gagal: {{ $errors->first() }}</strong>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Barang Keluar</h4>

                                    <button type="button" class="btn btn-primary ml-3 mr-3" data-target="#outModalCenter"
                                        data-toggle="modal"><strong>ADD</strong></button>

                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false"> <i class="fa fa-file-excel" aria-hidden="true"></i>
                                            Export Berdasarkan
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" data-target="#exportOutgoingCustomerModal"
                                                data-toggle="modal">Customer</a>
                                            <a class="dropdown-item" data-target="#exportOutgoingBrandModal"
                                                data-toggle="modal">Brand</a>
                                            <a class="dropdown-item" data-target="#exportOutgoingItemModal"
                                                data-toggle="modal">Barang</a>
                                            <a class="dropdown-item" data-target="#exportOutgoingALLModal"
                                                data-toggle="modal">Tanggal</a>
                                        </div>
                                    </div>

                                    {{-- export by customer --}}
                                    <div class="modal fade" id="exportOutgoingCustomerModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLongTitle">
                                                        <strong>
                                                            EXPORT BARANG KELUAR BERDASARKAN CUSTOMER
                                                        </strong>
                                                    </h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form method="post" action="/exportOutgoingCustomer">
                                                    @csrf
                                                    <div class="modal-body" style="padding:0">
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="customerLabelExport"
                                                                style="font-weight: bold">Customer</label>
                                                                <select class="form-control"
                                                                    id="customerLabelExportoutgoing" data-width="100%"
                                                                    name="customerOutgoing" required>
                                                                    <option></option>
                                                                    @foreach ($customer as $data)
                                                                        <option value="{{ $data->customer_id }}">
                                                                            {{ $data->customer_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="startRange" style="font-weight: bold">Dari Tanggal</label>
                                                                <input type="date" class="form-control form-control-sm" style="border-color: #aaaaaa"
                                                                    id="startRange" required name="startRange">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="endRange" style="font-weight: bold">Hingga Tanggal</label>
                                                                <input type="date" class="form-control form-control-sm" style="border-color: #aaaaaa" id="endRange"
                                                                    required name="endRange">
                                                            </div>

                                                            {{-- <div class="form-group">
                                                                <div class="card mt-5 ">
                                                                    <button id="" class="btn btn-primary">Export
                                                                        Data</button>
                                                                </div>
                                                            </div> --}}
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-primary">Export
                                                            Data</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- export by brand --}}
                                    <div class="modal fade" id="exportOutgoingBrandModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLongTitle">
                                                        <strong>
                                                            EXPORT BARANG KELUAR BERDASARKAN BRAND
                                                        </strong>
                                                    </h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form method="post" action="/exportOutgoingBrand">
                                                    @csrf
                                                    <div class="modal-body" style="padding:0">
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="brandLabelExport"
                                                                style="font-weight: bold">Brand</label>
                                                                <select class="form-control" id="brandLabelExportoutgoing"
                                                                    data-width="100%" name="brandOutgoing" required>
                                                                    <option></option>
                                                                    @foreach ($brand as $data)
                                                                        <option value="{{ $data->brand_id }}">
                                                                            {{ $data->brand_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="startRange" style="font-weight: bold">Dari Tanggal</label>
                                                                <input type="date" class="form-control form-control-sm" style="border-color: #aaaaaa"
                                                                    id="startRange" required name="startRange">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="endRange" style="font-weight: bold">Hingga Tanggal</label>
                                                                <input type="date" class="form-control form-control-sm" id="endRange" style="border-color: #aaaaaa"
                                                                    required name="endRange">
                                                            </div>

                                                            {{-- <div class="form-group">
                                                                <div class="card mt-5 ">
                                                                    <button id="" class="btn btn-primary">Export
                                                                        Data</button>
                                                                </div>
                                                            </div> --}}
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-primary">Export
                                                            Data</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- export by item --}}
                                    <div class="modal fade" id="exportOutgoingItemModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLongTitle">
                                                        <strong>
                                                            EXPORT BARANG KELUAR BERDASARKAN BARANG
                                                        </strong>
                                                    </h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form method="post" action="/exportOutgoingItem">
                                                    @csrf
                                                    <div class="modal-body" style="padding:0">
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="itemLabelExport" style="font-weight: bold">Nama Barang</label>
                                                                <select class="form-control" id="itemLabelExportoutgoing"
                                                                    data-width="100%" name="itemOutgoing" required>
                                                                    <option></option>
                                                                    @foreach ($item as $data)
                                                                        <option value="{{ $data->item_id }}">
                                                                            {{ $data->item_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="startRange" style="font-weight: bold">Dari Tanggal</label>
                                                                <input type="date" class="form-control form-control-sm" style="border-color: #aaaaaa"
                                                                    id="startRange" required name="startRange">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="endRange" style="font-weight: bold">Hingga Tanggal</label>
                                                                <input type="date" class="form-control form-control-sm" id="endRange" style="border-color: #aaaaaa"
                                                                    required name="endRange">
                                                            </div>

                                                            {{-- <div class="form-group">
                                                                <div class="card mt-5 ">
                                                                    <button id="" class="btn btn-primary">Export
                                                                        Data</button>
                                                                </div>
                                                            </div> --}}
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-primary">Export
                                                            Data</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- export by ALL --}}
                                    <div class="modal fade" id="exportOutgoingALLModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLongTitle">
                                                        <strong>
                                                            EXPORT SEMUA BARANG KELUAR
                                                        </strong>
                                                    </h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form method="post" action="/exportOutgoing">
                                                    @csrf
                                                    <div class="modal-body" style="padding:0">
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="startRange" style="font-weight: bold">Dari Tanggal</label>
                                                                <input type="date" class="form-control form-control-sm" style="border-color: #aaaaaa"
                                                                    id="startRange" required name="startRange">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="endRange" style="font-weight: bold">Hingga Tanggal</label>
                                                                <input type="date" class="form-control form-control-sm" id="endRange" style="border-color: #aaaaaa"
                                                                    required name="endRange">
                                                            </div>

                                                            {{-- <div class="form-group">
                                                                <div class="card mt-5 ">
                                                                    <button id="" class="btn btn-primary">Export
                                                                        Data</button>
                                                                </div>
                                                            </div> --}}
                                                        </div>
                                                        <input type="hidden" class="form-control" name="userIdHidden"
                                                            value="{{ auth()->user()->id }}">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-primary">Export
                                                            Data</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- REDUCE STOCK MODAL --}}
                                    <div class="modal fade" id="outModalCenter" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLongTitle">
                                                        <strong>
                                                            TAMBAHKAN BARANG KELUAR BARU
                                                        </strong>
                                                    </h3>
                                                    <button id="addOutgoingClose" style="display:inline-block"
                                                        type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" style="padding:0">
                                                    <form enctype="multipart/form-data" method="post"
                                                        action="/reduceItemStock">
                                                        @csrf

                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="outgoingidforitem" style="font-weight: bold">Nama Barang<span
                                                                        style="color: red"> (harus diisi)
                                                                    </span></label>
                                                                <select class="form-control" id="outgoingidforitem"
                                                                    data-width="100%" name="outgoingiditem">
                                                                    <option></option>
                                                                    @foreach ($item as $item)
                                                                        <option value="{{ $item->item_id }}">
                                                                            {{ $item->item_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="quantity" style="font-weight: bold">Stok<span style="color: red"> (harus
                                                                        diisi)
                                                                    </span></label>
                                                                <input type="text" id="quantity"
                                                                    name="itemReduceStock"style="width: 100%; border-color: #aaaaaa"
                                                                    class="form-control form-control-sm" placeholder="minimum 1">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="outgoingidforitem" style="font-weight: bold">Deskripsi<span
                                                                        style="color: red"> (harus diisi)
                                                                    </span></label>
                                                                <textarea class="form-control form-control-sm" id="outgoingidforitem" rows="3" style=" border-color: #aaaaaa" placeholder="deskripsi barang keluar"
                                                                    name="outgoingItemDesc"></textarea>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="startRange" style="font-weight: bold">Tanggal Barang Keluar<span
                                                                        style="color: red"> (harus diisi)
                                                                    </span></label>
                                                                <input type="date" class="form-control form-control-sm" style="border-color: #aaaaaa"
                                                                    id="startRange" name="itemDepart">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="largeInput" style="font-weight: bold">Gambar Barang Keluar<span
                                                                        style="color: red"> (harus diisi dan harus dibawah
                                                                        10MB)
                                                                    </span></label>
                                                                <input type="file" class="form-control form-control-sm" style="border-color: #aaaaaa"
                                                                    id="itemImage" name="outgoingItemImage">
                                                            </div>

                                                            <div class="form-group" style="padding-top:0; padding-bottom:0" id="submitOutgoingButtonAdd">
                                                                <div class="card mt-5 ">
                                                                    <button class="btn btn-primary"
                                                                        onclick="document.getElementById('itemAdd').style.display='inline-block';
                                                                        document.getElementById('addOutgoingClose').style.display='none';
                                                                        document.getElementById('overlayPage').style.display='inline-block';
                                                                        document.getElementById('submitOutgoingButtonAdd').style.display='none';
                                                                        document.getElementById('submitOutgoingButtonAddAfter').style.display='';">
                                                                        <strong>Insert
                                                                            Data</strong>

                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <div class="form-group" id="submitOutgoingButtonAddAfter"
                                                                style="display:none; padding-top:0; padding-bottom:0">
                                                                <div class="card mt-5 ">
                                                                    <button class="btn btn-primary" disabled>
                                                                        <strong>loading</strong>
                                                                        <i id="itemAdd" style="display:none"
                                                                            class="loading-icon fa fa-spinner fa-spin"
                                                                            aria-hidden="true"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" class="form-control"
                                                                name="userIdHidden" value="{{ auth()->user()->id }}">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="add-row" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Customer</th>
                                                <th>Brand</th>
                                                <th>ID Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Pengurangan Stok</th>
                                                <th>Tanggal Keluar</th>
                                                <th>Deskripsi</th>
                                                <th style="width: 11%">Gambar</th>
                                                <th style="width: 6%">Edit</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Customer</th>
                                                <th>Brand</th>
                                                <th>ID Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Pengurangan Stok</th>
                                                <th>Tanggal Keluar</th>
                                                <th>Deskripsi</th>
                                                <th>Gambar</th>
                                                <th>Edit</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($outgoing as $outgoing)
                                                <tr>
                                                    <td>{{ $outgoing->customer_name }}</td>
                                                    <td>{{ $outgoing->brand_name }}</td>
                                                    <td>{{ $outgoing->item_id }}</td>
                                                    <td>{{ $outgoing->item_name }}</td>
                                                    <td>{{ $outgoing->stock_taken }}</td>
                                                    {{-- <td>{{ $outgoing->depart_date }}</td> --}}
                                                    <td>{{ date_format(date_create($outgoing->depart_date), 'd-m-Y') }}
                                                    </td>
                                                    <td>{{ $outgoing->description }}</td>
                                                    <td>
                                                        <a style="cursor: pointer"
                                                            data-target="#imageModalCenter"
                                                            data-toggle="modal"
                                                            data-pic_url="{{ Storage::url($outgoing->item_pictures) }}"
                                                            data-item_name="{{ $outgoing->item_name }}"
                                                            data-item_date="{{ date_format(date_create($outgoing->depart_date), 'd-m-Y') }}">
                                                            <img class="rounded mx-auto d-block"
                                                                style="width: 100px; height: 50px; object-fit: cover;"
                                                                src="{{ Storage::url($outgoing->item_pictures) }}"
                                                                alt="no picture" loading="lazy">
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <a style="cursor: pointer" class="mb-2"
                                                                data-target="#editModalCenter{{ $outgoing->id }}"
                                                                data-toggle="modal">
                                                                <i class="fa fa-edit mt-3 text-primary"
                                                                    data-toggle="tooltip"
                                                                    data-original-title="Edit Data Barang Keluar"></i>
                                                            </a>
                                                            <a class="ml-3 mb-2" style="cursor: pointer"
                                                                data-target="#deleteModal"
                                                                data-toggle="modal"
                                                                data-item_name="{{ $outgoing->item_name }}"
                                                                data-item_id_enc="{{ encrypt($outgoing->id) }}"
                                                                data-item_stock="{{ $outgoing->stock_taken }}">
                                                                <i class="fa fa-times mt-3 text-danger"
                                                                    data-toggle="tooltip"
                                                                    data-original-title="Hapus Data Barang Keluar"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>

                                                {{-- UPDATE outgoing data MODALS --}}
                                                <div class="modal fade" id="editModalCenter{{ $outgoing->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <div class="d-flex flex-column">
                                                                    <div class="p-2">
                                                                        <h3 class="modal-title"
                                                                            id="exampleModalLongTitle">
                                                                            <strong> Update data untuk
                                                                                "{{ $outgoing->item_name }}"</strong>
                                                                        </h3>
                                                                    </div>
                                                                    <div class="p-2">
                                                                        <h5> Isi
                                                                            data yang ingin diubah</h5>
                                                                    </div>
                                                                </div>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form enctype="multipart/form-data" method="post"
                                                                    action="/updateOutgoingData">
                                                                    @csrf
                                                                    <div class="card-body">
                                                                        <div class="form-group">
                                                                            <div class="form-group">
                                                                                <label for="quantity">Stok</label>
                                                                                <input type="number" id="quantity"
                                                                                    name="outgoingEdit" min="0"
                                                                                    max="999999999999999"
                                                                                    style="width: 100%"
                                                                                    class="form-control"
                                                                                    placeholder="sebelumnya {{ $outgoing->stock_taken }}">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="largeInput">Gambar
                                                                                    Barang<span style="color: red"> (harus
                                                                                        dibawah 10MB)
                                                                                    </span></label>
                                                                                <input type="file"
                                                                                    class="form-control form-control"
                                                                                    id="itemImage"
                                                                                    name="outgoingItemImage">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <div class="card mt-5 ">
                                                                                    <button class="btn btn-primary"
                                                                                        onclick="document.getElementById('itemAdd1').style.display='inline-block';">
                                                                                        <strong>Update Data
                                                                                            Barang</strong>
                                                                                        <i id="itemAdd1"
                                                                                            style="display:none"
                                                                                            class="loading-icon fa fa-spinner fa-spin"
                                                                                            aria-hidden="true"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                            <div>
                                                                                <h5 style="text-align: center;">
                                                                                    kolom
                                                                                    yang tidak diisi
                                                                                    akan menggunakan data yang
                                                                                    sebelumnya</h5>
                                                                            </div>
                                                                        </div>

                                                                        <input type="hidden" class="form-control"
                                                                            name="outgoingIdHidden"
                                                                            value="{{ $outgoing->id }}">
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Delete Modal --}}
                <div class="modal fade" id="deleteModal">
                    <div class="modal-dialog modal-dialog-centered" >
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="exampleModalLabel" style="font-weight: bold"></h3>
                                <button type="button" class="close"
                                    data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p class="modal-text"></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    id="close-modal"
                                    data-dismiss="modal">Tidak</button>
                                <a href="#"
                                    class="deleteOutgoing btn btn-danger">YAKIN
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Fullsize Gambar --}}
                <div class="modal fade" id="imageModalCenter"
                    tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="padding: 0">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document"
                        style="min-width: auto; max-width: fit-content;">
                        <div class="modal-content" style="min-width:auto">
                            <div class="modal-header">
                                <h3 class="modal-title" id="exampleModalLongTitle" style="font-weight: bold"></h3>
                                <button type="button" class="close"
                                    data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body modal-img">
                                <img class="img-place rounded mx-auto d-block"
                                    style="height: 500px;  width:auto"
                                    src="#"
                                    alt="no picture" loading="lazy">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var item_name = button.data('item_name')
            var item_id_enc = button.data('item_id_enc')
            var item_stock = button.data('item_stock')
            var modal = $(this)


            modal.find('.modal-title').text('HAPUS BARANG')
            modal.find('.modal-text').text('Apa anda yakin untuk menghapus data barang keluar "' + item_name + '" ?\n jika dihapus, stok yang dimiliki akan bertambah sebanyak ' + item_stock)
            modal.find('.deleteOutgoing').attr('href', '/deleteItemOutgoing/' + item_id_enc)

        })

        $('#imageModalCenter').on('show.bs.modal', function(event) {
            $(".modal-img").css("padding", '0px');
            $(".modal-img").css("margin", '0px');
            var button = $(event.relatedTarget)
            var item_name = button.data('item_name')
            var item_date = button.data('item_date')
            var pic_url = button.data('pic_url')
            var modal = $(this)


            modal.find('.modal-title').text('GAMBAR "' + item_name + '" / ' + item_date)
            modal.find('.img-place').attr('src', pic_url)
        })
    </script>

@endsection
