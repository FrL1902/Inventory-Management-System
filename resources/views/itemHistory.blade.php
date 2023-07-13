@extends('layout.layout')

@section('manageitembutton', 'active')
@section('managehistory', 'active')
@section('showmanageitem', 'show')

@section('content')
    <div class="main-panel">
        <div class="content">
            {{-- ini page buat liat history keluar masuk stock tiap produk / item --}}
            <div class="page-inner">

                {{-- @if (session('sukses_delete_brand'))
                    <div class="alert alert-warning alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ session('sukses_delete_brand') }}</strong>
                    </div>
                @elseif (session('sukses_editBrand'))
                    <div class="alert alert-primary alert-block" id="alerts">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Sukses mengupdate data "{{ session('sukses_editBrand') }}"</strong>
                    </div>
                @elseif ($errors->any())
                    <div class="alert alert-danger alert-block" id="alerts">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Update Failed, validation not met</strong>
                    </div>
                @endif --}}

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                {{-- <div class="d-flex align-items-center"> --}}
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex flex-row">
                                        <span>

                                        </span>
                                        <h4 class="card-title mt-1 mr-3">
                                            <span class="align-middle">
                                                Sejarah Stok
                                            </span>
                                        </h4>
                                        <div class="ml-3 mr-2 mt-2">
                                            <span class="align-middle">
                                                Export Berdasarkan
                                            </span>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-secondary"
                                                data-target="#exportItemHistorymModal"
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
                                    <div class="modal fade" id="exportItemHistorymModal" tabindex="-1" role="dialog"
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
                                                                {{-- <label for="customerLabelExport">Item Name</label>
                                                                <select class="form-control" id="customerLabelExport"
                                                                    name="itemHistoryExport">
                                                                    @foreach ($history as $data)
                                                                        <option value="{{ $data->item_name }}">
                                                                            {{ $data->item_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select> --}}

                                                                <label for="largeInput">Item Name (case sensitive)</label>
                                                                <input type="text" class="form-control form-control"
                                                                    placeholder="item name" name="itemHistoryExport">

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
                                                <th>History ID</th>
                                                <th>Item Name</th>
                                                <th>Stock before</th>
                                                <th>Stock added</th>
                                                <th>Stock taken</th>
                                                <th>Stock after</th>
                                                <th>Updated At (system)</th>
                                                <th>By User</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                {{--
                                                History ID : IDnya kyknya gini aja deh, TRSN1,  "TRSN" nya kode awal, angka belakangnya increment berdasarkan ID
                                                Item name // jelas kali ya darimana, figure it out
                                                Stock Before // jelas kali ya darimana, figure it out
                                                Stock Added // jelas kali ya darimana, figure it out
                                                Stock Taken // jelas kali ya darimana, figure it out
                                                Stock Now // jelas kali ya darimana, figure it out
                                                Updated At : ini tunjukin created at
                                                By User : ini pake auth --}}

                                                <th>History ID</th>
                                                <th>Item Name</th>
                                                <th>Stock before</th>
                                                <th>Stock added</th>
                                                <th>Stock taken</th>
                                                <th>Stock after</th>
                                                <th>Updated At (system)</th>
                                                <th>By User</th>

                                            </tr>
                                        </tfoot>
                                        <tbody>

                                            @foreach ($history as $history)
                                                <tr>
                                                    <td>{{ $history->id }}</td>
                                                    <td>{{ $history->item_name }}</td>
                                                    <td>{{ $history->stock_before }}</td>
                                                    <td>{{ $history->stock_added }}</td>
                                                    <td>{{ $history->stock_taken }}</td>
                                                    <td>{{ $history->stock_now }}</td>
                                                    {{-- <td>{{ $history->created_at }}</td> --}}
                                                    <td>{{ date_format(date_create($history->created_at), 'D, H:i:s, d-m-Y') }}
                                                    </td>
                                                    <td>{{ $history->user_who_did }}
                                                    </td>
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
