@extends('layout.layout')


@section('manageitembutton', 'active') {{-- ini bagian folder nya --}}
@section('showmanageitem', 'show') {{-- ini bagian folder nya yang buka tutup --}}
@section('report', 'active') {{-- ini bagian button side panel yang di highlight nya --}}

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
                                            data-toggle="modal"><strong>Barang</strong>
                                        </button>
                                        <button type="button" class="btn btn-secondary"
                                            data-target="#exportHistoryByDateModal"
                                            data-toggle="modal"><strong>Tanggal</strong>
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-secondary" data-target="#sortByDateModal"
                                        data-toggle="modal"><strong>Filter by Date</strong>
                                    </button>
                                    @if (session('deleteFilterButton'))
                                        <a type="button" class="btn btn-danger" style="cursor: pointer"
                                            href="/manageHistory">Remove Filter</a>
                                    @endif

                                </div>

                                {{-- export by ALL --}}
                                <div class="modal fade" id="exportItemReportModal" tabindex="-1" role="dialog"
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
                                                <form method="post" action="/exportItemHistory">
                                                    @csrf

                                                    <div class="card-body">
                                                        <div class="form-group">
                                                                <select class="form-control" data-width="100%"
                                                                id="itemHistoryExport" name="itemHistoryExport">
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
                                            <th>ID Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Stok</th>
                                            <th>Palet</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Stok</th>
                                            <th>Palet</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($pallet as $data)
                                            <tr>
                                                <td>{{ $data->item_id }}</td>
                                                <td>{{ $data->item_name }}</td>
                                                <td>{{ $data->stock }}</td>
                                                <td>{{ $data->bin }}</td>
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
