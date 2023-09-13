@extends('layout.layout')


@section('managepalletbutton', 'active') {{-- ini bagian folder nya --}}
@section('showmanagepallet', 'show') {{-- ini bagian folder nya yang buka tutup --}}
@section('managepallethistory', 'active') {{-- ini bagian button side panel yang di highlight nya --}}


@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">

                                    <div class="d-flex flex-row">
                                        <h4 class="card-title mt-1 mr-3">
                                            <span class="align-middle">
                                                <strong>Sejarah Palet</strong>
                                            </span>
                                        </h4>
                                        <div class="ml-3 mr-2 mt-2">
                                            <span class="align-middle">
                                                Export Berdasarkan
                                            </span>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-secondary"
                                                data-target="#exportPalletItemHistorymModal"
                                                data-toggle="modal"><strong>Barang</strong>
                                            </button>
                                            <button type="button" class="btn btn-secondary"
                                                data-target="#exportPalletHistoryByDateModal"
                                                data-toggle="modal"><strong>Tanggal</strong>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- export by ALL --}}
                                    <div class="modal fade" id="exportPalletItemHistorymModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLongTitle">
                                                        <strong>
                                                            Print an item's history
                                                        </strong>
                                                    </h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                {{-- export by item name --}}
                                                <div class="modal-body">
                                                    <form method="post" action="/exportPalletItemHistory">
                                                        @csrf

                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                    <select class="form-control" data-width="100%"
                                                                    id="itemPalletHistoryExport" name="itemPalletHistoryExport">
                                                                    @foreach ($item as $item)
                                                                        <option value="{{ $item->item_id }}">
                                                                            {{ $item->item_name }}</option>
                                                                    @endforeach
                                                                </select>
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
                                                <th>Status</th>
                                                <th>Waktu (system)</th>
                                                <th>User</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Nama Barang</th>
                                                <th>Stok</th>
                                                <th>BIN</th>
                                                <th>Status</th>
                                                <th>Waktu (system)</th>
                                                <th>User</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>

                                            @foreach ($palletHistory as $pallet)
                                                <tr>
                                                    <td>{{ $pallet->item_name }}</td>
                                                    <td>{{ $pallet->stock }}</td>
                                                    <td>{{ $pallet->bin }}</td>
                                                    @if ($pallet->status == 'KELUAR')
                                                        <td style="display: block; min-width:200px; text-align: center;">
                                                            <strong>
                                                                <p
                                                                    style="margin: auto; color: white; background-color: rgb(189, 66, 55);border-radius: 25px">
                                                                    {{ $pallet->status }}</p>
                                                            </strong>
                                                        </td>
                                                    @elseif ($pallet->status == 'DALAM INVENTORY')
                                                        <td style="display: block; text-align: center; min-width:200px;">
                                                            <strong>
                                                                <p
                                                                    style="margin: auto; color: white; background-color: rgb(55, 111, 189);border-radius: 25px">
                                                                    {{ $pallet->status }}</p>
                                                            </strong>
                                                        </td>
                                                    @elseif (str_contains($pallet->status, 'SEBAGIAN'))
                                                        <td style="display: block; text-align: center; min-width:200px;">
                                                            <strong>
                                                                <p
                                                                    style="margin: auto; color: white; background-color:rgb(189, 173, 55);border-radius: 25px">
                                                                    {{ $pallet->status }}</p>
                                                            </strong>
                                                        </td>
                                                        {{-- <td style="text-align: center"><strong>
                                                            <p
                                                                style="margin: auto; color: white; background-color: {{ $pallet->status == 'KELUAR' ? 'rgb(189, 66, 55)' : 'rgb(55, 111, 189)' }};border-radius: 25px">
                                                                {{ $pallet->status }}</p>
                                                        </strong> --}}
                                                    @endif
                                                    <td>{{ $pallet->created_at }}</td>
                                                    <td>{{ $pallet->name }}</td>
                                                </tr>
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
