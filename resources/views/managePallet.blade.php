@extends('layout.layout')


@section('managepalletbutton', 'active') {{-- ini bagian folder nya --}}
@section('showmanagepallet', 'show') {{-- ini bagian folder nya yang buka tutup --}}
@section('managepallet', 'active') {{-- ini bagian button side panel yang di highlight nya --}}


@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                {{-- ini page buat manage pallet
                mungkin isinya harus bbrp data

                nama Barang
                jumlah stok
                BIN (ni kyk lokasi palet)
                keterangan

                harusnya 4 itu aja sih --}}
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
                                    <h4 class="card-title"><strong>Mengelola Palet</strong></h4>
                                    <button type="button" class="btn btn-primary ml-3 mr-3" data-target="#addPalletModal"
                                        data-toggle="modal"><strong>ADD</strong></button>

                                    <div class="modal fade" id="addPalletModal" tabindex="-1" role="dialog"
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
                                                <div class="modal-body">
                                                    <form method="post" action="/addNewPallet">
                                                        @csrf

                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="itemidforpallet">Nama Barang<span
                                                                        style="color: red"> (harus diisi)
                                                                    </span></label>
                                                                <select class="form-control" data-width="100%"
                                                                    id="itemidforpallet" name="itemidforpallet">
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
                                                                <label for="incomingItemDesc">Keterangan<span
                                                                        style="color: red"> (harus diisi)
                                                                    </span></label>
                                                                <textarea class="form-control" id="incomingItemDesc" rows="3" placeholder="deskripsi barang masuk"
                                                                    name="palletDesc" required></textarea>
                                                            </div>

                                                            <div class="form-group">
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
                                                <th style="width: 30%">Nama Barang</th>
                                                <th>Stok</th>
                                                <th>BIN</th>
                                                <th style="width: 35%">Keterangan</th>
                                                <th style="width: 7%">Edit</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Nama Barang</th>
                                                <th>Stok</th>
                                                <th>BIN</th>
                                                <th>Keterangan</th>
                                                <th>Edit</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>

                                            @foreach ($pallet as $pallet)
                                                <tr>
                                                    <td>{{ $pallet->item->item_name }}</td>
                                                    <td>{{ $pallet->stock }}</td>
                                                    <td>{{ $pallet->bin }}</td>
                                                    <td>{{ $pallet->description }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <a style="cursor: pointer"
                                                                data-target="#editModalCenter{{ $pallet->id }}"
                                                                data-toggle="modal">
                                                                <i class="fa fa-edit mt-3 text-primary"
                                                                    data-toggle="tooltip"
                                                                    data-original-title="Edit barang di palet ini"></i>
                                                            </a>
                                                            <a class="ml-3 mb-2" style="cursor: pointer"
                                                                data-target="#reducePalletStockModal{{ $pallet->id }}"
                                                                data-toggle="modal">
                                                                <i class="fa fa-arrow-right mt-3 text-danger"
                                                                    data-toggle="tooltip"
                                                                    data-original-title="Keluarkan Stok Palet"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <div class="modal fade" id="reducePalletStockModal{{ $pallet->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <div class="d-flex flex-column">
                                                                    <div class="p-2">
                                                                        <h3 class="modal-title"
                                                                            id="exampleModalLongTitle">
                                                                            <strong> Keluarkan Stok barang
                                                                                "{{ $pallet->item->item_name }}"</strong>
                                                                        </h3>
                                                                    </div>
                                                                </div>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post" action="/reducePalletStock">
                                                                    @csrf
                                                                    <div class="card-body">
                                                                        <div class="form-group">
                                                                            <div class="form-group">
                                                                                <label for="quantity">Stok</label>
                                                                                <input type="number" id="quantity"
                                                                                    name="palletStockOut" min="1"
                                                                                    max="999999999999999"
                                                                                    style="width: 100%"
                                                                                    class="form-control"
                                                                                    placeholder="min 1" required>
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
                                                                            value="{{ $pallet->id }}">
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- the original "remove" pallet --}}
                                                {{-- <div class="modal fade" id="deleteModal{{ $pallet->id }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">
                                                                    <strong>Pengeluaran Palet</strong>
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Apakah anda yakin untuk mengeluarkan palet
                                                                    "{{ $pallet->bin }}" yang berisi barang
                                                                    "{{ $pallet->item->item_name }}
                                                                    ({{ $pallet->stock }})" ?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    id="close-modal" data-dismiss="modal">Tidak</button>
                                                                <a href="/removePallet/{{ encrypt($pallet->id) }}"
                                                                    class="btn btn-danger">YAKIN
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> --}}
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
