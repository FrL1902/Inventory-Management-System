@extends('layout.layout')

@section('managebrandbutton', 'active')
@section('showmanagebrand', 'show')
@section('newbrand', 'active')

@section('content')
    <div class="main-panel">
        <div class="content">
            ini page buat add new brands
            <div class="page-inner">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            {{-- masih ga tau cara input id nya gmn  --}}
                            <form action="/makeBrand" method="post">
                                @csrf
                                <div class="card-header">
                                    <div class="card-title">New Brand</div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">The owner of the brand</label>
                                        <select class="form-control" id="exampleFormControlSelect1"
                                            name="exampleFormControlSelect1">
                                            @foreach ($customer as $cust)
                                                <option value="{{ $cust->customer_id }}">{{ $cust->customer_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="largeInput">Brand ID</label>
                                        <input type="text" class="form-control form-control" placeholder="BD001"
                                            id="brandid" name="brandid">
                                    </div>
                                    <div class="form-group">
                                        <label for="largeInput">Brand Name</label>
                                        <input type="text" class="form-control form-control" placeholder="Oreo"
                                            id="brandname" name="brandname">
                                    </div>
                                </div>
                                <div class="card-action">
                                    <button class="btn btn-success">Submit</button>
                                    <button class="btn btn-danger">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
