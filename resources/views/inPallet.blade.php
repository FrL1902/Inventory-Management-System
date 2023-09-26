@extends('layout.layout')


@section('managepalletbutton', 'active') {{-- ini bagian folder nya --}}
@section('showmanagepallet', 'show') {{-- ini bagian folder nya yang buka tutup --}}
@section('inpallet', 'active') {{-- ini bagian button side panel yang di highlight nya --}}


@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                @if (session('gagalMasukPaletVALUE'))
                    <div class="alert alert-danger alert-block" id="alertFailed">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Gagal Memasukkan Data: {{ session('gagalMasukPaletVALUE') }}</strong>
                    </div>
                @elseif (session('suksesMasukPaletVALUE'))
                    <div class="alert alert-success alert-block" id="alertSuccess">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Sukses Memasukkan Data: {{ session('suksesMasukPaletVALUE') }}</strong>
                    </div>
                @elseif (session('gagalStokPalletKeluar'))
                    <div class="alert alert-danger alert-block" id="alertFailed">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Gagal Mengeluarkan Stok Palet: {{ session('gagalStokPalletKeluar') }}</strong>
                    </div>
                @elseif (session('suksesPaletKeluar'))
                    <div class="alert alert-success alert-block" id="alertSuccess">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ session('suksesPaletKeluar') }}: barang dikeluarkan, stok barang di palet ini sudah
                            habis</strong>
                    </div>
                @elseif (session('suksesPaletKeluar2'))
                    <div class="alert alert-success alert-block" id="alertSuccess">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Sukses mengeluarkan stok palet: {{ session('suksesPaletKeluar2') }}</strong>
                    </div>
                @elseif ($errors->any())
                    <div class="alert alert-danger alert-block" id="alertFailed">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Gagal Memasukkan Data: {{ $errors->first() }}</strong>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title"><strong>Palet Masuk</strong></h4>
                                    <button type="button" class="btn btn-primary ml-3 mr-3" data-target="#addInPalletModal"
                                        data-toggle="modal"><strong>ADD</strong></button>

                                    <div class="modal fade" id="addInPalletModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLongTitle">
                                                        <strong>
                                                            Tambahkan Data Barang di Palet
                                                        </strong>
                                                    </h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                {{-- memasukkan data palet baru --}}
                                                <div class="modal-body">
                                                    <form enctype="multipart/form-data" method="post"
                                                        action="/addNewPallet">
                                                        @csrf

                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="itemidforpallet">Nama Barang<span
                                                                        style="color: red"> (harus dipilih)
                                                                    </span></label>
                                                                <select class="form-control" data-width="100%"
                                                                    id="itemidforpallet" name="itemidforpallet" required>
                                                                    <option></option>
                                                                    @foreach ($item as $item)
                                                                        <option value="{{ $item->item_id }}">
                                                                            {{ $item->item_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="quantity">Stok<span style="color: red"> (harus
                                                                        diisi)
                                                                    </span></label>
                                                                <input type="number" id="quantity" name="palletStock"
                                                                    min="1" max="999999999" style="width: 100%"
                                                                    class="form-control" placeholder="min 1, max 999999999"
                                                                    required>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="largeInput">BIN <span style="color: red"> (harus
                                                                        diisi)
                                                                    </span></label>
                                                                <input type="text" class="form-control form-control"
                                                                    placeholder="Contoh: J2.1" id="bin" name="bin"
                                                                    required>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="startRange">Tanggal Barang Datang<span
                                                                        style="color: red"> (harus diisi)
                                                                    </span></label>
                                                                <input type="date" class="form-control" id="startRange"
                                                                    required name="palletArrive">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="incomingItemDesc">Keterangan<span
                                                                        style="color: red"> (harus diisi)
                                                                    </span></label>
                                                                <textarea class="form-control" id="incomingItemDesc" rows="3" placeholder="deskripsi barang masuk"
                                                                    name="palletDesc" required></textarea>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="largeInput">Gambar Palet/Barang Datang<span
                                                                        style="color: red"> (harus diisi)
                                                                    </span></label>
                                                                <input type="file" class="form-control form-control"
                                                                    id="itemImage" name="inPalletImage" required>
                                                                <div class="card mt-5 ">
                                                                    <button id="" class="btn btn-primary">Insert
                                                                        Data</button>
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
                                                <th>Stok</th>
                                                <th>BIN</th>
                                                <th>Tanggal Masuk</th>
                                                <th>Deskripsi</th>
                                                <th>Gambar</th>
                                                <th style="width: 5%">Keluar</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Customer</th>
                                                <th>Brand</th>
                                                <th>ID Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Stok</th>
                                                <th>BIN</th>
                                                <th>Tanggal Masuk</th>
                                                <th>Deskripsi</th>
                                                <th>Gambar</th>
                                                <th>Keluar</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>

                                            @foreach ($inpallet as $data)
                                                <tr>
                                                    <td>{{ $data->customer_name }}</td>
                                                    <td>{{ $data->brand_name }}</td>
                                                    <td>{{ $data->item_id }}</td>
                                                    <td>{{ $data->item_name }}</td>
                                                    <td>{{ $data->stock }}</td>
                                                    <td>{{ $data->bin }}</td>
                                                    <td>{{ date_format(date_create($data->user_date), 'D d-m-Y') }}
                                                    <td>{{ $data->description }}</td>
                                                    <td>
                                                        <a style="cursor: pointer"
                                                            data-target="#imageModalCenter{{ $data->id }}"
                                                            data-toggle="modal">
                                                            <img class="rounded mx-auto d-block"
                                                                style="width: 100px; height: auto;"
                                                                src="{{ Storage::url($data->item_pictures) }}"
                                                                alt="no picture" loading="lazy">
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <a class="mb-2" style="cursor: pointer"
                                                                data-target="#reducePalletStockModal{{ $data->id }}"
                                                                data-toggle="modal">
                                                                <i class="fa fa-arrow-right mt-3 text-danger"
                                                                    data-toggle="tooltip"
                                                                    data-original-title="Keluarkan Stok Palet"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>

                                                {{-- FullSize Gambar --}}
                                                <div class="modal fade" id="imageModalCenter{{ $data->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h3 class="modal-title" id="exampleModalLongTitle">
                                                                    <strong>Foto Barang
                                                                        "{{ $data->item_name }}" pada
                                                                        {{ date_format(date_create($data->user_date), 'D d-m-Y') }}</strong>
                                                                </h3>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img class="rounded mx-auto d-block"
                                                                    style="width: 750px; height: auto;"
                                                                    src="{{ Storage::url($data->item_pictures) }}"
                                                                    alt="no picture" loading="lazy">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- kurangin stok dari palet --}}
                                                <div class="modal fade" id="reducePalletStockModal{{ $data->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <div class="d-flex flex-column">
                                                                    <div class="p-2">
                                                                        <h3 class="modal-title"
                                                                            id="exampleModalLongTitle">
                                                                            <strong> Keluarkan Stok Barang Dari Palet
                                                                                "{{ $data->item_name }}"</strong>
                                                                        </h3>
                                                                    </div>
                                                                </div>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form enctype="multipart/form-data" method="post"
                                                                    action="/reducePalletStock">
                                                                    @csrf
                                                                    <div class="card-body">
                                                                        <div class="form-group">
                                                                            <label for="itemidforpallet">Nama
                                                                                Barang</label>
                                                                            <input class="form-control" type="text"
                                                                                placeholder="{{ $data->item_name }}"
                                                                                readonly>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="itemidforpallet">BIN</label>
                                                                            <input class="form-control" type="text"
                                                                                placeholder="{{ $data->bin }}"
                                                                                readonly>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="quantity">Stok</label>
                                                                            <input type="number" id="quantity"
                                                                                name="palletStockOut" min="1"
                                                                                max="999999999999999" style="width: 100%"
                                                                                class="form-control" placeholder="min 1"
                                                                                required>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="startRange">Tanggal Barang
                                                                                Datang<span style="color: red"> (harus
                                                                                    diisi)
                                                                                </span></label>
                                                                            <input type="date" class="form-control"
                                                                                id="startRange" required
                                                                                name="palletDepart">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="incomingItemDesc">Keterangan<span
                                                                                    style="color: red"> (harus diisi)
                                                                                </span></label>
                                                                            <textarea class="form-control" id="incomingItemDesc" rows="3" placeholder="deskripsi barang keluar"
                                                                                name="palletDesc" required></textarea>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="largeInput">Gambar Palet/Barang
                                                                                Datang<span style="color: red"> (harus
                                                                                    diisi)
                                                                                </span></label>
                                                                            <input type="file"
                                                                                class="form-control form-control"
                                                                                id="itemImage" name="outPalletImage"
                                                                                required>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <div class="card mt-5 ">
                                                                                <button id=""
                                                                                    class="btn btn-primary">Keluarkan
                                                                                    Stok Palet</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" class="form-control"
                                                                        name="palletIdHidden"
                                                                        value="{{ $data->id }}">
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
