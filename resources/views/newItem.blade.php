@extends('layout.layout')

@section('content')

@section('manageitembutton', 'active')
@section('newitem', 'active')
@section('showmanageitem', 'show')


<div class="main-panel">
    <div class="content">
        ini page buat add new item

        <div class="page-inner">

            @if (session('sukses_addNewItem'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Item "{{ session('sukses_addNewItem') }}" is successfully added</strong>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Item input failed, validation not met: {{ $errors->first() }}</strong>
                </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <form method="post" action="/makeItem">
                            @csrf
                            <div class="card-header">
                                <div class="card-title">Add New Item</div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="brandidforitem">The brand of the item</label>
                                    <select class="form-control" id="brandidforitem" name="brandidforitem">
                                        @foreach ($brand as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="largeInput">Item Name</label>
                                    <input type="text" class="form-control form-control" placeholder="pancake"
                                        id="itemname" name="itemname">
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Stock</label>
                                    <input type="number" id="quantity" name="itemStock" min="0" max="1000000"
                                        style="width: 200px" class="form-control">
                                </div>
                                <div class="card mt-4">
                                    <button class="btn btn-success">Insert New Item</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
