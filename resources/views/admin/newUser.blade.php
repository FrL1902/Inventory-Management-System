@extends('layout.layout')

@section('content')

@section('manageuserbutton', 'active')
@section('showmanageuser', 'show')
@section('newuser', 'active')


<div class="main-panel">
    <div class="content">
        <div class="page-inner">

            @if (session('sukses_add'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ session('sukses_add') }}</strong>
                </div>
            @elseif ($errors->any())
                <div class="alert alert-danger alert-block" id="alerts">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Pembuatan User Baru Gagal, validation not met: {{ $errors->first() }}</strong>
                </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <form method="post" action="/makeUser">
                            @csrf
                            <div class="card-header">
                                <div class="card-title">Make New User Account</div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" placeholder="Username" aria-label=""
                                        aria-describedby="basic-addon1" name="usernameform">
                                </div>
                                <div class="form-group">
                                    <label for="email1">Email Address</label>
                                    <input type="email" class="form-control" id="email1" placeholder="Enter Email"
                                        name="emailform">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    {{-- <input type="password" class="form-control" id="password" placeholder="Password"
                                        name="passwordform" required> --}}
                                    {{-- contoh "required" kalo lgsg dari htmlnya^, tp sih pake aja yg dari phpnya --}}
                                    <input type="password" class="form-control" id="password" placeholder="Password"
                                        name="passwordform">
                                </div>
                                <div class="form-check">
                                    <label>Role</label><br />
                                    <label class="form-radio-label">
                                        <input class="form-radio-input" type="radio" name="optionsRadios"
                                            value="admin" checked="">
                                        <span class="form-radio-sign">Admin</span>
                                    </label>
                                    <label class="form-radio-label ml-3">
                                        <input class="form-radio-input" type="radio" name="optionsRadios"
                                            value="gudang">
                                        <span class="form-radio-sign">Gudang</span>
                                    </label>
                                    <label class="form-radio-label ml-3">
                                        <input class="form-radio-input" type="radio" name="optionsRadios"
                                            value="customer">
                                        <span class="form-radio-sign">Customer</span>
                                    </label>
                                </div>
                                <div class="card mt-4">
                                    <button id="" class="btn btn-success">Make New Account</button>
                                </div>
                                {{-- @if ($errors->any())
                                    <span class="text-danger">{{ $errors->first() }}</span>
                                @endif --}}

                                {{-- @if ($errors->any())
                                    @foreach ($errors->all() as $err)
                                        <li class="text-danger">{{ $err }}</li>
                                    @endforeach
                                @endif --}}
                                {{-- @include('sweetalert::alert') --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
