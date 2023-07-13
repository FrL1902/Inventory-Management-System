@extends('layout.layout')

@section('manageitembutton', 'active')
@section('newoutgoing', 'active')
{{-- ganti yang atas ini aja --}}
@section('showmanageitem', 'show')

@section('content')
    <div class="main-panel">
        <div class="content">
            {{-- tes template, outgoing --}}
            <div class="page-inner">

                {{-- error goes here --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-block" id="alertFailed">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Data Gagal Dimasukkan: {{ $errors->first() }}</strong>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title"><strong>Barang Keluar</strong></h4>

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
                                    {{-- <div class="ml-3 mr-2">
                                        Export ke Excel Berdasarkan
                                    </div>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-secondary"
                                            data-target="#exportOutgoingCustomerModal"
                                            data-toggle="modal"><strong>Customer</strong>
                                        </button>

                                        <button type="button" class="btn btn-secondary"
                                            data-target="#exportOutgoingBrandModal"
                                            data-toggle="modal"><strong>Brand</strong>
                                        </button>

                                        <button type="button" class="btn btn-secondary"
                                            data-target="#exportOutgoingItemModal"
                                            data-toggle="modal"><strong>Barang</strong>
                                        </button>

                                        <button type="button" class="btn btn-secondary"
                                            data-target="#exportOutgoingALLModal"
                                            data-toggle="modal"><strong>Tanggal</strong>
                                        </button>
                                    </div> --}}

                                    {{-- export by customer --}}
                                    <div class="modal fade" id="exportOutgoingCustomerModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLongTitle">
                                                        <strong>
                                                            Export barang keluar berdasarkan Customer
                                                        </strong>
                                                    </h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="/exportOutgoingCustomer">
                                                        @csrf

                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="customerLabelExport">Customer</label>
                                                                <select class="form-control" id="customerLabelExport"
                                                                    name="customerOutgoing">
                                                                    @foreach ($customer as $data)
                                                                        <option value="{{ $data->id }}">
                                                                            {{ $data->customer_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="startRange">Dari Tanggal</label>
                                                                <input type="date" class="form-control" id="startRange"
                                                                    required name="startRange">
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
                                    <div class="modal fade" id="exportOutgoingBrandModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLongTitle">
                                                        <strong>
                                                            Export barang keluar berdasarkan Brand
                                                        </strong>
                                                    </h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="/exportOutgoingBrand">
                                                        @csrf

                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="brandLabelExport">Brand</label>
                                                                <select class="form-control" id="brandLabelExport"
                                                                    name="brandOutgoing">
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
                                    <div class="modal fade" id="exportOutgoingItemModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLongTitle">
                                                        <strong>
                                                            Export barang keluar berdasarkan nama barang
                                                        </strong>
                                                    </h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="/exportOutgoingItem">
                                                        @csrf

                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="itemLabelExport">Nama Barang</label>
                                                                <select class="form-control" id="itemLabelExport"
                                                                    name="itemOutgoing">
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
                                    <div class="modal fade" id="exportOutgoingALLModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLongTitle">
                                                        <strong>
                                                            Print semua data barang keluar
                                                        </strong>
                                                    </h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="/exportOutgoing">
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

                                    {{-- REDUCE STOCK MODAL --}}
                                    <div class="modal fade" id="outModalCenter" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLongTitle">
                                                        <strong>
                                                            Tambahkan Barang Keluar Baru
                                                        </strong>
                                                    </h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form enctype="multipart/form-data" method="post"
                                                        action="/reduceItemStock">
                                                        @csrf

                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="outgoingidforitem">Nama Barang</label>
                                                                <select class="form-control" id="outgoingidforitem"
                                                                    name="outgoingiditem">
                                                                    @foreach ($item as $item)
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item->item_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="quantity">Stok</label>
                                                                <input type="number" id="quantity"
                                                                    name="itemReduceStock" min="1"
                                                                    max="999999999999999" style="width: 100%"
                                                                    class="form-control" placeholder="minimum 1" required>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="outgoingidforitem">Deskripsi</label>
                                                                <textarea class="form-control" id="outgoingidforitem" rows="3" placeholder="deskripsi barang keluar"
                                                                    name="outgoingItemDesc" required></textarea>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="startRange">Tanggal Barang Keluar</label>
                                                                <input type="date" class="form-control"
                                                                    id="startRange" required name="itemDepart">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="largeInput">Gambar Barang Keluar</label>
                                                                <input type="file" class="form-control form-control"
                                                                    id="itemImage" name="outgoingItemImage" required>
                                                                <div class="card mt-5 ">
                                                                    <button id="" class="btn btn-primary">Insert
                                                                        Data</button>
                                                                </div>
                                                            </div>

                                                            <input type="hidden" class="form-control"
                                                                name="userIdHidden" value="{{ auth()->user()->id }}">

                                                            {{-- <input type="hidden" class="form-control"
                                                                name="customerIdHidden" value="{{ $item->customer->id }}">
                                                            <input type="hidden" class="form-control" name="brandIdHidden"
                                                                value="{{ $item->brand->id }}">
                                                            <input type="hidden" class="form-control" name="itemIdHidden"
                                                                value="{{ $item->id }}"> --}}
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
                                                <th>Jumlah Pengurangan Stok</th>
                                                <th>Tanggal Keluar</th>
                                                <th>Deskripsi</th>
                                                <th>Gambar</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Customer</th>
                                                <th>Brand</th>
                                                <th>ID Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah Pengurangan Stok</th>
                                                <th>Tanggal Keluar</th>
                                                <th>Deskripsi</th>
                                                <th>Gambar</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($outgoing as $outgoing)
                                                <tr>
                                                    <td>{{ $outgoing->customer->customer_name }}</td>
                                                    <td>{{ $outgoing->brand->brand_name }}</td>
                                                    <td>{{ $outgoing->item_id }}</td>
                                                    <td>{{ $outgoing->item_name }}</td>
                                                    <td>{{ $outgoing->stock_taken }}</td>
                                                    {{-- <td>{{ $outgoing->depart_date }}</td> --}}
                                                    <td>{{ date_format(date_create($outgoing->depart_date), 'D d-m-Y') }}
                                                    </td>
                                                    <td>{{ $outgoing->description }}</td>
                                                    <td>
                                                        <a style="cursor: pointer"
                                                            data-target="#imageModalCenter{{ $outgoing->id }}"
                                                            data-toggle="modal">
                                                            <img class="rounded mx-auto d-block"
                                                                style="width: 100px; height: auto;"
                                                                src="{{ Storage::url($outgoing->item_pictures) }}"
                                                                alt="no picture" loading="lazy">
                                                        </a>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="imageModalCenter{{ $outgoing->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h3 class="modal-title" id="exampleModalLongTitle">
                                                                    <strong>Barang Keluar
                                                                        "{{ $outgoing->item_name }}" pada
                                                                        {{ $outgoing->created_at }}</strong>
                                                                </h3>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img class="rounded mx-auto d-block"
                                                                    style="width: 750px; height: auto;"
                                                                    src="{{ Storage::url($outgoing->item_pictures) }}"
                                                                    alt="no picture" loading="lazy">
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
