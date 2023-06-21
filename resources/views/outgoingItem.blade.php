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
                @if ($errors->any())
                    <div class="alert alert-danger alert-block" id="alerts">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Update Failed, validation not met, error is: {{ $errors->first() }}</strong>
                    </div>
                @endif

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
                                                    <h3 class="modal-title" id="exampleModalLongTitle">
                                                        <strong>
                                                            Add New Outgoing Item
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
                                                                <label for="quantity">Stock</label>
                                                                <input type="number" id="quantity" name="itemReduceStock"
                                                                    min="1" max="{{ $item->stocks }}"
                                                                    style="width: 100%" class="form-control"
                                                                    placeholder="minimum 1" required>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="outgoingidforitem">Description</label>
                                                                <textarea class="form-control" id="outgoingidforitem" rows="3" placeholder="deskripsi outgoing package"
                                                                    name="outgoingItemDesc" required></textarea>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="largeInput">Outgoing Package Image</label>
                                                                <input type="file" class="form-control form-control"
                                                                    id="itemImage" name="outgoingItemImage" required>
                                                                <div class="card mt-5 ">
                                                                    <button id="" class="btn btn-primary">Insert
                                                                        Data</button>
                                                                </div>
                                                            </div>

                                                            <input type="hidden" class="form-control" name="userIdHidden"
                                                                value="{{ auth()->user()->id }}">

                                                            <input type="hidden" class="form-control"
                                                                name="customerIdHidden" value="{{ $item->customer->id }}">
                                                            <input type="hidden" class="form-control" name="brandIdHidden"
                                                                value="{{ $item->brand->id }}">
                                                            <input type="hidden" class="form-control" name="itemIdHidden"
                                                                value="{{ $item->id }}">
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
                                                <th>Customer</th>
                                                <th>Brand</th>
                                                <th>Item ID</th>
                                                <th>Item Name</th>
                                                <th>Stock Taken</th>
                                                <th>Time Added</th>
                                                <th>Description</th>
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
                                                    <td>{{ $outgoing->created_at }}</td>
                                                    <td>{{ $outgoing->description }}</td>
                                                    <td><img class="rounded mx-auto d-block"
                                                            style="width: 100px;
                                                    height: auto;"
                                                            src="{{ Storage::url($outgoing->item_pictures) }}"
                                                            alt="no picture"></td>
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
