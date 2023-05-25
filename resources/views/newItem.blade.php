@extends('layout.layout')

@section('content')

@section('manageitembutton', 'active')
@section('newitem', 'active')
@section('showmanageitem', 'show')


<div class="main-panel">
    <div class="content">
        ini page buat add new item

        <div class="page-inner">

            {{-- @if (session('sukses_addNewCustomer'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ session('sukses_addNewCustomer') }}</strong>
                </div>
            @endif --}}

            @if ($errors->any())
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Customer input failed, validation not met, check error in the bottom</strong>
                </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <form method="post" action="">
                            @csrf
                            <div class="card-header">
                                <div class="card-title">Add New Item</div>
                            </div>
                            <div class="card-body">


                                @if ($errors->any())
                                    @foreach ($errors->all() as $err)
                                        <li class="text-danger">{{ $err }}</li>
                                    @endforeach
                                @endif
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
