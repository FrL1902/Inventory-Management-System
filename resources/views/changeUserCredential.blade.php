@extends('layout.layout')

@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">

                @if (session('passwordInputDifferent'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ session('passwordInputDifferent') }}</strong>
                    </div>
                @elseif (session('passwordSameOld'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ session('passwordSameOld') }}</strong>
                    </div>
                @elseif (session('passwordUpdated'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ session('passwordUpdated') }}</strong>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Update Gagal: panjang password baru harus 6 - 20 karakter</strong>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <form method="post" action="/updateUser">
                                @csrf
                                <div class="card-header">
                                    <div class="card-title">Change Password</div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="largeInput">Email</label>
                                        <input class="form-control" type="text" placeholder="{{ $user->email }}"
                                            aria-label="Disabled input example" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="largeInput">Username</label>
                                        <input class="form-control" type="text" placeholder="{{ $user->name }}"
                                            aria-label="Disabled input example" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="largeInput">Role</label>
                                        <input class="form-control" type="text" placeholder="{{ $user->level }}"
                                            aria-label="Disabled input example" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="placeholder"><b>New Password</b></label>
                                        <div class="position-relative">
                                            <input id="password" name="changePassword" type="password" class="form-control"
                                                required>
                                            <div class="show-password">
                                                <i class="flaticon-interface"> show password</i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="placeholder"><b>Confirm Password</b></label>
                                        <div class="position-relative">
                                            <input id="password" name="changePassword2" type="password"
                                                class="form-control" required>
                                            <div class="show-password">
                                                <i class="flaticon-interface"> show password</i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mt-4">
                                        <button class="btn btn-success">Change Password</button>
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
