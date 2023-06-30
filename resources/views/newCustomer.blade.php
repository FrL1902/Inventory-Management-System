@extends('layout.layout')

@section('content')

@section('managecustomerbutton', 'active')
@section('newcustomer', 'active')
@section('showmanagecustomer', 'show')

<style>
    /* Success Animation */
    #alertSuccess {
        position: relative;
        animation-name: success;
        animation-duration: 0.7s;
        animation-iteration-count: 1;
    }

    @keyframes success {
        0% {
            left: 200px;
            top: 0px;
            background-color: rgb(0, 255, 76);
        }

        100% {
            left: 0px;
            top: 0px;
            background-color: white;
        }
    }


    /* Failed Animation */
    #alertFailed {
        position: relative;
        animation-name: failedAnimation;
        animation-duration: 0.7s;
        animation-iteration-count: 1;
    }

    @keyframes failedAnimation {
        0% {
            left: 200px;
            top: 0px;
            background-color: red;
        }

        100% {
            left: 0px;
            top: 0px;
            background-color: white;
        }
    }
</style>

<div class="main-panel">
    <div class="content">
        {{-- ini page buat add new customer --}}

        <div class="page-inner">

            @if (session('sukses_addNewCustomer'))
                <div class="alert alert-success alert-block" id="alertSuccess">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ session('sukses_addNewCustomer') }}</strong>
                </div>
                {{-- @elseif (session('formatError'))
                <div class="alert alert-danger alert-block" id="alertFailed">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Data Gagal Dimasukkan, {{ session('formatError') }} <span style="color: red"> \ /  : * ? " < > |
                    </span></strong>
                </div> --}}
            @elseif ($errors->any())
                <div class="alert alert-danger alert-block" id="alertFailed">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Data Gagal Dimasukkan: {{ $errors->first() }}</strong>
                </div>
            @endif
            {{-- @if ($errors->any())
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Customer input failed, validation not met, check error in the bottom</strong>
                </div>
            @endif --}}



            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <form method="post" action="/makeCustomer">
                            @csrf
                            <div class="card-header">
                                <div class="card-title"><strong>Masukkan Customer Baru</strong></div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="largeInput">ID Customer<span style="color: red"> (harus diisi)
                                        </span></label>
                                    <input type="text" class="form-control form-control" placeholder="Contoh: CU001"
                                        id="customerid" name="customerid">
                                    {{--  --}}
                                </div>
                                <div class="form-group">
                                    <label for="largeInput">Nama Customer<span style="color: red"> (harus diisi)
                                        </span></label>
                                    <input type="text" class="form-control form-control"
                                        placeholder="masukkan nama lengkap customer" id="customername"
                                        name="customername">
                                    {{--  --}}
                                </div>
                                <div class="form-group">
                                    <label for="largeInput">Alamat Customer<span style="color: red"> (harus diisi)
                                        </span></label>
                                    <input type="text" class="form-control form-control"
                                        placeholder="masukkan alamat customer" id="address" name="address">
                                    {{--  --}}
                                </div>
                                <div class="form-group">
                                    <label for="email">Email Customer</label>
                                    <input type="email" class="form-control" placeholder="masukkan email customer"
                                        id="email" name="email">
                                </div>
                                <div class="form-group">
                                    <label for="largeInput">Nomor Telpon 1 Customer</label>
                                    <input type="text" class="form-control form-control" placeholder="(021)"
                                        id="phone1" name="phone1">
                                </div>
                                <div class="form-group">
                                    <label for="largeInput">Nomor Telpon 2 Customer</label>
                                    <input type="text" class="form-control form-control" placeholder="+62"
                                        id="phone2" name="phone2">
                                </div>
                                <div class="form-group">
                                    <label for="largeInput">Nomor Fax Customer</label>
                                    <input type="text" class="form-control form-control" placeholder="(021)"
                                        id="fax" name="fax">
                                </div>
                                <div class="form-group">
                                    <label for="largeInput">Website Customer</label>
                                    <input type="text" class="form-control form-control"
                                        placeholder="contoh: https://www.user.com" id="website" name="website">
                                </div>
                                <div class="form-group">
                                    <label for="largeInput">Nama PIC (person in charge)</label>
                                    <input type="text" class="form-control form-control"
                                        placeholder="masukkan nama lengkap PIC" id="picname" name="picname">
                                </div>
                                <div class="form-group">
                                    <label for="largeInput">Nomor Telpon PIC</label>
                                    <input type="text" class="form-control form-control" placeholder="(021) atau +62"
                                        id="picnumber" name="picnumber">
                                </div>
                                <div class="form-group">
                                    <label for="largeInput">NPWP (Nomor Pokok Wajib Pajak)</label>
                                    <input type="text" class="form-control form-control"
                                        placeholder="Contoh: 08.111.555.1-123.321" id="npwp" name="npwp">
                                </div>
                                <div class="form-group">
                                    <div class="card mt-4">
                                        <button class="btn btn-success">Tambahkan Customer Baru</button>
                                    </div>
                                </div>

                                {{-- @if ($errors->any())
                                    @foreach ($errors->all() as $err)
                                        <li class="text-danger">{{ $err }}</li>
                                    @endforeach
                                @endif --}}
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
