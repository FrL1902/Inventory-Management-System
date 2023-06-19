@extends('layout.layout')

@section('manageitembutton', 'active')
@section('newincoming', 'active')
{{-- ganti yang atas ini aja --}}
@section('showmanageitem', 'show')

@section('content')
    <div class="main-panel">
        <div class="content">
            tes template, incoming
            <div class="page-inner">

                {{-- error goes here --}}

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Incoming Item</h4>

                                    <button type="button" class="btn btn-primary ml-3 mr-3" data-target="#addModalCenter"
                                        data-toggle="modal"><strong>ADD</strong></button>

                                    <div class="ml-3 mr-2">
                                        Export by
                                    </div>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-secondary text-white">
                                            <input class="text-white" type="radio" name="options" id="option1"
                                                autocomplete="off"> Customer
                                        </label>
                                        <label class="btn btn-secondary text-white">
                                            <input type="radio" name="options" id="option2" autocomplete="off"> Brand
                                        </label>
                                        <label class="btn btn-secondary text-white">
                                            <input type="radio" name="options" id="option3" autocomplete="off"> Item
                                        </label>
                                    </div>

                                    <button type="button" class="btn btn-primary ml-3">
                                        <a href="/exportIncoming">
                                            <strong>EXPORT EXCEL</strong>
                                        </a>
                                    </button>


                                    <div class="modal fade" id="addModalCenter" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">
                                                        Add New Incoming Item</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form enctype="multipart/form-data" method="post"
                                                        action="/addItemStock">
                                                        @csrf

                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="incomingidforitem">Item Name</label>
                                                                <select class="form-control" id="incomingidforitem"
                                                                    name="incomingiditem">
                                                                    @foreach ($item as $item)
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item->item_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="quantity">Stock</label>
                                                                <input type="number" id="quantity" name="itemAddStock"
                                                                    min="1" max="1000000" style="width: 100%"
                                                                    class="form-control" placeholder="minimum 1" required>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="incomingidforitem">Description</label>
                                                                <textarea class="form-control" id="incomingidforitem" rows="3" placeholder="deskripsi incoming package"
                                                                    name="incomingItemDesc" required></textarea>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="largeInput">Incoming Package Image</label>
                                                                <input type="file" class="form-control form-control"
                                                                    id="itemImage" name="incomingItemImage" required>
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
                                                            <input type="hidden" class="form-control"
                                                                name="itemIdHidden" value="{{ $item->id }}">

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
                                                <th>Stock Added</th>
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
                                                <th>Stock Added</th>
                                                <th>Time Added</th>
                                                <th>Description</th>
                                                <th>Gambar</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($incoming as $incoming)
                                                <tr>
                                                    <td>{{ $incoming->customer->customer_name }}</td>
                                                    <td>{{ $incoming->brand->brand_name }}</td>
                                                    <td>{{ $incoming->item_id }}</td>
                                                    {{-- <td>{{ $incoming->customer_id }}</td>
                                                    <td>{{ $incoming->brand_id }}</td>
                                                    <td>{{ $incoming->item_id }}</td> --}}
                                                    <td>{{ $incoming->item_name }}</td>
                                                    <td>{{ $incoming->stock_added }}</td>
                                                    <td>{{ $incoming->created_at }}</td>
                                                    <td>{{ $incoming->description }}</td>
                                                    <td><img class="rounded mx-auto d-block"
                                                            style="width: 100px;
                                                    height: auto;"
                                                            src="{{ Storage::url($incoming->item_pictures) }}"
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
