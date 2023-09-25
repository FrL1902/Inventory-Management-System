@extends('layout.layout')


@section('managepalletbutton', 'active') {{-- ini bagian folder nya --}}
@section('showmanagepallet', 'show') {{-- ini bagian folder nya yang buka tutup --}}
@section('palletreport', 'active') {{-- ini bagian button side panel yang di highlight nya --}}

@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                {{-- Disini customer bisa melihat posisi palet untuk setiap barang secara langsung --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex flex-row">
                                        <h4 class="card-title mt-1 mr-3">
                                            <span class="align-middle">
                                                Laporan Barang
                                            </span>
                                        </h4>
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
                                                <th>Tanggal Sampai</th>
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
                                                <th>Stok</th>
                                                <th>BIN</th>
                                                <th>Tanggal Sampai</th>
                                                <th>Deskripsi</th>
                                                <th>Gambar</th>
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
