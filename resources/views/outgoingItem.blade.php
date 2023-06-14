@extends('layout.layout')

@section('manageitembutton', 'active')
@section('newoutgoing', 'active')
{{-- ganti yang atas ini aja --}}
@section('showmanageitem', 'show')

@section('content')
    <div class="main-panel">
        <div class="content">
            tes template, outgoing
            <div class="page-inner">

                {{-- error goes here --}}

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Outgoing Item</h4>

                                    <button type="button" class="btn btn-primary ml-3" data-target="#outModalCenter"
                                        data-toggle="modal"><strong>ADD</strong></button>

                                    <div class="modal fade" id="outModalCenter" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">
                                                        Add New Outgoing Item</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="/reduceItemStock">
                                                        @csrf

                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="outgoingidforitem">Item Name</label>
                                                                <select class="form-control" id="outgoingidforitem"
                                                                    name="outgoingiditem">
                                                                    @foreach ($item as $item)
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item->item_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="outgoingidforitem">Images</label>
                                                                <input class="form-control" type="text"
                                                                    placeholder="Image, not implemented yet" readonly>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="outgoingidforitem">Description</label>
                                                                <input class="form-control" type="text"
                                                                    placeholder="Description, not implemented yet" readonly>
                                                            </div>

                                                            <div class="form-group">

                                                                <label for="quantity">Stock</label>
                                                                <input type="number" id="quantity" name="itemReduceStock"
                                                                    min="1" max="{{ $item->stocks }}"
                                                                    style="width: 100%" class="form-control"
                                                                    placeholder="minimum 1" required>

                                                                <div class="card mt-5 ">
                                                                    <button id="" class="btn btn-primary">Update
                                                                        Data</button>
                                                                </div>
                                                            </div>

                                                            <input type="hidden" class="form-control" name="userIdHidden"
                                                                value="{{ auth()->user()->id }}">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <h4 class="card-title">Manage Existing Items and its Stocks</h4> --}}
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="add-row" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Item ID</th>
                                                <th>Item Name</th>
                                                <th>Stock Taken</th>
                                                <th>Time Added</th>
                                                <th>Description</th>
                                                <th>Gambar</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Item ID</th>
                                                <th>Item Name</th>
                                                <th>Stock Taken</th>
                                                <th>Time Added</th>
                                                <th>Description</th>
                                                <th>Gambar</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($history as $history)
                                                @if ($history->stock_taken > 0)
                                                    <tr>
                                                        <td>Item ID</td>
                                                        <td>{{ $history->item_name }}</td>
                                                        <td>{{ $history->stock_taken }}</td>
                                                        <td>{{ $history->created_at }}</td>
                                                        <td>Description</td>
                                                        <td>Gambar</td>
                                                    </tr>
                                                @endif
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
