@extends('layout.layout')


@section('manageitembutton', 'active') {{-- ini bagian folder nya --}}
@section('showmanageitem', 'show') {{-- ini bagian folder nya yang buka tutup --}}
@section('itemreport', 'active') {{-- ini bagian button side panel yang di highlight nya --}}

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
                                    <div class="ml-3 mr-2 mt-2">
                                        <span class="align-middle">
                                            Export Berdasarkan
                                        </span>
                                    </div>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-secondary"
                                            data-target="#exportItemReportModal"
                                            data-toggle="modal"><strong>Brand</strong>
                                        </button>
                                        {{-- <button type="button" class="btn btn-secondary"
                                            data-target="#exportHistoryByDateModal"
                                            data-toggle="modal"><strong>Tanggal</strong>
                                        </button> --}}
                                    </div>
                                </div>
                                {{-- <div>
                                    <button type="button" class="btn btn-secondary" data-target="#sortByDateModal"
                                        data-toggle="modal"><strong>Filter by Date</strong>
                                    </button>
                                    @if (session('deleteFilterButton'))
                                        <a type="button" class="btn btn-danger" style="cursor: pointer"
                                            href="/manageHistory">Remove Filter</a>
                                    @endif

                                </div> --}}

                                {{-- export by ALL --}}
                                <div class="modal fade" id="exportItemReportModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="exampleModalLongTitle">
                                                    <strong>
                                                        Print a brand's report
                                                    </strong>
                                                </h3>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            {{-- export by item name --}}
                                            <div class="modal-body">
                                                <form method="post" action="/exportItemReport">
                                                    @csrf
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                                <select class="form-control" data-width="100%"
                                                                id="itemIdReportCustomer" name="itemIdReportCustomer">
                                                                @foreach ($brand as $data)
                                                                    <option value="{{ $data->brand_id }}">
                                                                        {{ $data->brand_name }}</option>
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

                                {{-- export by ALL --}}
                                <div class="modal fade" id="exportHistoryByDateModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="exampleModalLongTitle">
                                                    <strong>
                                                        Print History By Date
                                                    </strong>
                                                </h3>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="/exportHistoryByDate">
                                                    @csrf

                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="startRange">Start Date Range</label>
                                                            <input type="date" class="form-control" id="startRange"
                                                                required name="startRange">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="endRange">End Date Range</label>
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

                                {{-- filter by date --}}
                                <div class="modal fade" id="sortByDateModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="exampleModalLongTitle">
                                                    <strong>
                                                        Filter by date range
                                                    </strong>
                                                </h3>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="/filterHistoryDate">
                                                    @csrf

                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="startRange">Start Date Range</label>
                                                            <input type="date" class="form-control"
                                                                id="startRange" required name="startRange">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="endRange">End Date Range</label>
                                                            <input type="date" class="form-control" id="endRange"
                                                                required name="endRange">
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="card mt-5 ">
                                                                <button id=""
                                                                    class="btn btn-primary">Sort</button>
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
                                            <th>Customer</th>
                                            <th>Brand</th>
                                            <th>ID Barang</th>
                                            <th>Nama Barang</th>
                                            <th style="width: 8%">Stok</th>
                                            <th style="width: 8%">Palet</th>
                                            <th style="width: 13%">Gambar Barang</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Customer</th>
                                            <th>Brand</th>
                                            <th>ID Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Stok</th>
                                            <th>Palet</th>
                                            <th>Gambar Barang</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($pallet as $data)
                                            <tr>
                                                <td>{{ $data->customer_name }}</td>
                                                <td>{{ $data->brand_name }}</td>
                                                <td>{{ $data->item_id }}</td>
                                                <td>{{ $data->item_name }}</td>
                                                <td>{{ $data->stock }}</td>
                                                <td>{{ $data->bin }}</td>
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
                                            <div class="modal fade" id="imageModalCenter{{ $data->id }}"
                                                tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg"
                                                    role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3 class="modal-title" id="exampleModalLongTitle">
                                                                <strong>Gambar barang "
                                                                    {{ $data->item_name }}"</strong>
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
