@extends('layout.layout')

@section('manageitembutton', 'active')
@section('managehistory', 'active')
@section('showmanageitem', 'show')

@section('content')
    <div class="main-panel">
        <div class="content">
            ini page buat liat history keluar masuk stock tiap produk / item
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
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">History of stocks</h4>
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
                                                <th>Stock now</th>
                                                <th>Updated At</th>
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
                                                <th>Stock now</th>
                                                <th>Updated At</th>
                                                <th>By User</th>

                                            </tr>
                                        </tfoot>
                                        <tbody>

                                            @foreach ($item as $item)
                                                <tr>
                                                    <td>{{ $item->stocks }}</td>
                                                    <td>{{ $item->stocks }}</td>
                                                    <td>{{ $item->stocks }}</td>
                                                    <td>{{ $item->stocks }}</td>
                                                    <td>{{ $item->stocks }}</td>
                                                    <td>{{ $item->stocks }}</td>
                                                    <td>{{ $item->stocks }}</td>
                                                    <td>{{ $item->stocks }}
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
