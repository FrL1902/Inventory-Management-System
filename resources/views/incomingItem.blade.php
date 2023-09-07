@extends('layout.layout')

@section('manageitembutton', 'active')
@section('newincoming', 'active')
{{-- ganti yang atas ini aja --}}
@section('showmanageitem', 'show')

@section('content')
    <div class="main-panel">
        <div class="content">
            {{-- tes template, incoming --}}
            <div class="page-inner">

                {{-- error goes here --}}
                @if (session('intOverflow'))
                    <div class="alert alert-danger alert-block" id="alertFailed">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Gagal: {{ session('intOverflow') }}</strong>
                    </div>
                @elseif (session('sukses_addStock'))
                    <div class="alert alert-success alert-block" id="alertSuccess">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Sukses menambah stok" {{ session('sukses_addStock') }}"</strong>
                    </div>
                @elseif (session('newValueMinus'))
                    <div class="alert alert-danger alert-block" id="alertFailed">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Gagal: {{ session('newValueMinus') }}</strong>
                    </div>
                @elseif (session('suksesDeleteIncoming'))
                    <div class="alert alert-warning alert-block" id="alertDelete">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ session('suksesDeleteIncoming') }}</strong>
                    </div>
                @elseif (session('suksesUpdateIncoming'))
                    <div class="alert alert-success alert-block" id="alertSuccess">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ session('suksesUpdateIncoming') }}</strong>
                    </div>
                @elseif (session('noData_editItem'))
                    <div class="alert alert-danger alert-block" id="alertFailed">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Gagal: Tidak ada data yang dimasukkan</strong>
                    </div>
                @elseif($errors->any())
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
                                    <h4 class="card-title"><strong>Barang Datang</strong></h4>

                                    <button type="button" class="btn btn-primary ml-3 mr-3" data-target="#addModalCenter"
                                        data-toggle="modal"><strong>ADD</strong></button>

                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false"> <i class="fa fa-file-excel" aria-hidden="true"></i>
                                            Export Berdasarkan
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" data-target="#exportIncomingCustomerModal"
                                                data-toggle="modal">Customer</a>
                                            <a class="dropdown-item" data-target="#exportIncomingBrandModal"
                                                data-toggle="modal">Brand</a>
                                            <a class="dropdown-item" data-target="#exportIncomingItemModal"
                                                data-toggle="modal">Barang</a>
                                            <a class="dropdown-item" data-target="#exportIncomingALLModal"
                                                data-toggle="modal">Tanggal</a>
                                        </div>
                                    </div>
                                    {{-- <div class="ml-3 mr-2">
                                        Export ke Excel Berdasarkan
                                    </div> --}}
                                    {{-- <div class="btn-group">
                                        <button type="button" class="btn btn-secondary"
                                            data-target="#exportIncomingCustomerModal"
                                            data-toggle="modal"><strong>Customer</strong>
                                        </button>

                                        <button type="button" class="btn btn-secondary"
                                            data-target="#exportIncomingBrandModal"
                                            data-toggle="modal"><strong>Brand</strong>
                                        </button>

                                        <button type="button" class="btn btn-secondary"
                                            data-target="#exportIncomingItemModal"
                                            data-toggle="modal"><strong>Barang</strong>
                                        </button>

                                        <button type="button" class="btn btn-secondary"
                                            data-target="#exportIncomingALLModal"
                                            data-toggle="modal"><strong>Tanggal</strong>
                                        </button>
                                    </div> --}}

                                    {{-- export by customer --}}
                                    <div class="modal fade" id="exportIncomingCustomerModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLongTitle">
                                                        <strong>
                                                            Export barang datang berdasarkan Customer
                                                        </strong>
                                                    </h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="/exportIncomingCustomer">
                                                        @csrf

                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="customerLabelExportIncoming">Customer</label>
                                                                <select class="form-control"
                                                                    id="customerLabelExportIncoming" data-width="100%"
                                                                    name="customerIncoming">
                                                                    @foreach ($customer as $data)
                                                                        <option value="{{ $data->id }}">
                                                                            {{ $data->customer_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="startRange">Dari Tanggal</label>
                                                                <input type="date" class="form-control"
                                                                    id="startRange" required name="startRange">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="endRange">Hingga Tanggal</label>
                                                                <input type="date" class="form-control" id="endRange"
                                                                    required name="endRange">
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="card mt-5 ">
                                                                    <button id="" class="btn btn-primary">Export
                                                                        Data</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- export by brand --}}
                                    <div class="modal fade" id="exportIncomingBrandModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLongTitle">
                                                        <strong>
                                                            Export barang datang berdasarkan Brand
                                                        </strong>
                                                    </h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="/exportIncomingBrand">
                                                        @csrf

                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="brandLabelExportincoming">Brand</label>
                                                                <select class="form-control" id="brandLabelExportincoming"
                                                                    data-width="100%" name="brandIncoming">
                                                                    @foreach ($brand as $data)
                                                                        <option value="{{ $data->id }}">
                                                                            {{ $data->brand_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="startRange">Dari Tanggal</label>
                                                                <input type="date" class="form-control"
                                                                    id="startRange" required name="startRange">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="endRange">Hingga Tanggal</label>
                                                                <input type="date" class="form-control" id="endRange"
                                                                    required name="endRange">
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="card mt-5 ">
                                                                    <button id="" class="btn btn-primary">Export
                                                                        Data</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- export by item --}}
                                    <div class="modal fade" id="exportIncomingItemModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLongTitle">
                                                        <strong>
                                                            Export barang datang berdasarkan nama barang
                                                        </strong>
                                                    </h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="/exportIncomingItem">
                                                        @csrf

                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="itemLabelExportincoming">Nama
                                                                    Barang</label>
                                                                <select class="form-control" id="itemLabelExportincoming"
                                                                    data-width="100%" name="itemIncoming">
                                                                    @foreach ($item as $data)
                                                                        <option value="{{ $data->id }}">
                                                                            {{ $data->item_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="startRange">Dari Tanggal</label>
                                                                <input type="date" class="form-control"
                                                                    id="startRange" required name="startRange">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="endRange">Hingga Tanggal</label>
                                                                <input type="date" class="form-control" id="endRange"
                                                                    required name="endRange">
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="card mt-5 ">
                                                                    <button id="" class="btn btn-primary">Export
                                                                        Data</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- export by ALL --}}
                                    <div class="modal fade" id="exportIncomingALLModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLongTitle">
                                                        <strong>
                                                            Print semua data barang datang
                                                        </strong>
                                                    </h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="/exportIncoming">
                                                        @csrf

                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="startRange">Dari Tanggal</label>
                                                                <input type="date" class="form-control"
                                                                    id="startRange" required name="startRange">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="endRange">Hingga Tanggal</label>
                                                                <input type="date" class="form-control" id="endRange"
                                                                    required name="endRange">
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="card mt-5 ">
                                                                    <button id="" class="btn btn-primary">Export
                                                                        Data</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- ADD STOCK MODAL --}}
                                    <div class="modal fade" id="addModalCenter" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLongTitle">
                                                        <strong>
                                                            Tambahkan Barang Datang Baru
                                                        </strong>
                                                    </h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form enctype="multipart/form-data" method="post"
                                                        action="/addItemStock">
                                                        @csrf

                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="incomingidforitem">Nama Barang<span
                                                                        style="color: red"> (harus diisi)
                                                                    </span></label>
                                                                <select class="form-control" data-width="100%"
                                                                    id="incomingidforitem" name="incomingiditem">
                                                                    @foreach ($item as $item)
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item->item_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="quantity">Stok<span style="color: red"> (harus
                                                                        diisi)
                                                                    </span></label>
                                                                <input type="number" id="quantity" name="itemAddStock"
                                                                    min="1" max="999999999" style="width: 100%"
                                                                    class="form-control"
                                                                    placeholder="min 1, max 999999999" required>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="incomingidforitem">Deskripsi<span
                                                                        style="color: red"> (harus diisi)
                                                                    </span></label>
                                                                <textarea class="form-control" id="incomingidforitem" rows="3" placeholder="deskripsi barang masuk"
                                                                    name="incomingItemDesc" required></textarea>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="startRange">Tanggal Barang Datang<span
                                                                        style="color: red"> (harus diisi)
                                                                    </span></label>
                                                                <input type="date" class="form-control"
                                                                    id="startRange" required name="itemArrive">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="largeInput">Gambar Barang Datang<span
                                                                        style="color: red"> (harus diisi)
                                                                    </span></label>
                                                                <input type="file" class="form-control form-control"
                                                                    id="itemImage" name="incomingItemImage" required>
                                                                <div class="card mt-5 ">
                                                                    <button id="" class="btn btn-primary">Insert
                                                                        Data</button>
                                                                </div>
                                                            </div>

                                                            <input type="hidden" class="form-control"
                                                                name="userIdHidden" value="{{ auth()->user()->id }}">

                                                            {{-- <input type="hidden" class="form-control"
                                                                name="customerIdHidden"
                                                                value="{{ $item->customer->id }}">
                                                            <input type="hidden" class="form-control"
                                                                name="brandIdHidden" value="{{ $item->brand->id }}"> --}}
                                                            {{-- <input type="hidden" class="form-control"
                                                                name="itemIdHidden" value="{{ $item->id }}"> --}}

                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- TABEL --}}
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="add-row" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Customer</th>
                                                <th>Brand</th>
                                                <th>ID Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Penambahan Stok</th>
                                                <th>Tanggal Sampai</th>
                                                <th>Deskripsi</th>
                                                <th>Gambar</th>
                                                @auth
                                                    @if (Auth::user()->level == 'admin')
                                                        <th>Edit (admin)</th>
                                                    @endif
                                                @endauth
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Customer</th>
                                                <th>Brand</th>
                                                <th>ID Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Penambahan Stok</th>
                                                <th>Tanggal Sampai</th>
                                                <th>Deskripsi</th>
                                                <th>Gambar</th>
                                                @auth
                                                    @if (Auth::user()->level == 'admin')
                                                        <th>Edit (admin)</th>
                                                    @endif
                                                @endauth
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($incoming as $incoming)
                                                <tr>
                                                    <td>{{ $incoming->customer->customer_name }}</td>
                                                    <td>{{ $incoming->brand->brand_name }}</td>
                                                    <td>{{ $incoming->item->item_id }}</td>
                                                    <td>{{ $incoming->item->item_name }}</td>
                                                    <td>{{ $incoming->stock_added }}</td>
                                                    <td>{{ date_format(date_create($incoming->arrive_date), 'D d-m-Y') }}
                                                    </td>
                                                    {{-- <td>{{ $incoming->arrive_date }}</td> --}}
                                                    <td>{{ $incoming->description }}</td>
                                                    <td>
                                                        <a style="cursor: pointer"
                                                            data-target="#imageModalCenter{{ $incoming->id }}"
                                                            data-toggle="modal">
                                                            <img class="rounded mx-auto d-block"
                                                                style="width: 100px; height: auto;"
                                                                src="{{ Storage::url($incoming->item_pictures) }}"
                                                                alt="no picture" loading="lazy">
                                                        </a>
                                                    </td>
                                                    @auth
                                                        @if (Auth::user()->level == 'admin')
                                                            <td>
                                                                <div class="d-flex justify-content-center">
                                                                    <a style="cursor: pointer" class="mb-2"
                                                                        data-target="#editModalCenter{{ $incoming->id }}"
                                                                        data-toggle="modal">
                                                                        <i class="fa fa-edit mt-3 text-primary"
                                                                            data-toggle="tooltip"
                                                                            data-original-title="Edit Data Barang Masuk"></i>
                                                                    </a>
                                                                    <a class="ml-3 mb-2" style="cursor: pointer"
                                                                        data-target="#deleteModal{{ $incoming->id }}"
                                                                        data-toggle="modal">
                                                                        <i class="fa fa-times mt-3 text-danger"
                                                                            data-toggle="tooltip"
                                                                            data-original-title="Hapus Data Barang Masuk"></i>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        @endif
                                                    @endauth
                                                </tr>
                                                {{-- FullSize Gambar --}}
                                                <div class="modal fade" id="imageModalCenter{{ $incoming->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h3 class="modal-title" id="exampleModalLongTitle">
                                                                    <strong>Barang Datang
                                                                        "{{ $incoming->item->item_name }}" pada
                                                                        {{ $incoming->created_at }}</strong>
                                                                </h3>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img class="rounded mx-auto d-block"
                                                                    style="width: 750px; height: auto;"
                                                                    src="{{ Storage::url($incoming->item_pictures) }}"
                                                                    alt="no picture" loading="lazy">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- delete incoming data MODALS --}}
                                                <div class="modal fade" id="deleteModal{{ $incoming->id }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">
                                                                    <strong>PENGHAPUSAN DATA BARANG MASUK</strong>
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Apakah anda yakin untuk menghapus data barang masuk
                                                                    "{{ $incoming->item->item_name }}" ?</p>
                                                                <p>Jika dihapus, stok yang dimiliki akan berkurang
                                                                    sebanyak
                                                                    <strong>{{ $incoming->stock_added }}
                                                                        barang</strong>
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    id="close-modal" data-dismiss="modal">Tidak</button>
                                                                <a href="/deleteItemIncoming/{{ encrypt($incoming->id) }}"
                                                                    class="btn btn-danger">YAKIN
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- UPDATE incoming data MODALS --}}
                                                <div class="modal fade" id="editModalCenter{{ $incoming->id }}"
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
                                                                                "{{ $incoming->item->item_name }}"</strong>
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
                                                                    action="/updateIncomingData">
                                                                    @csrf
                                                                    <div class="card-body">
                                                                        <div class="form-group">
                                                                            <div class="form-group">
                                                                                <label for="quantity">Stok</label>
                                                                                <input type="number" id="quantity"
                                                                                    name="incomingEdit" min="0"
                                                                                    max="999999999999999"
                                                                                    style="width: 100%"
                                                                                    class="form-control"
                                                                                    placeholder="sebelumnya {{ $incoming->stock_added }}">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="largeInput">Gambar
                                                                                    Barang</label>
                                                                                <input type="file"
                                                                                    class="form-control form-control"
                                                                                    id="itemImage" name="itemImage">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <div class="card mt-5 ">
                                                                                    <button id=""
                                                                                        class="btn btn-primary">Update
                                                                                        Data Barang</button>
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
                                                                            name="itemIdHidden"
                                                                            value="{{ $incoming->id }}">
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
            </div>
        </div>
    </div>
@endsection
