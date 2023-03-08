@extends('layout.layout')

@section('content')

@section('manageuserbutton', 'active')
@section('showmanageuser', 'show')
@section('newuser', 'active')


<div class="main-panel">
    <div class="content">
        ini buat create new user / udah bisa add, tapi kurang validations
        <div class="page-inner">
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
                                    <input type="text" class="form-control" placeholder="Username"
                                        aria-label="Username" aria-describedby="basic-addon1" name="username" required>
                                </div>
                                <div class="form-group">
                                    <label for="email1">Email Address</label>
                                    <input type="email" class="form-control" id="email1" placeholder="Enter Email"
                                        name="email" required>
                                    <small id="emailHelp2" class="form-text text-muted">We'll never share your email
                                        with anyone else.</small>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" placeholder="Password"
                                        name="password" required>
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
                                </div>
                                <div class="card mt-4">
                                    <button class="btn btn-success">Make New Account</button>
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
