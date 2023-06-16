@extends('layout.layout')

@section('content')

@section('manageuserbutton', 'active')
@section('showmanageuser', 'show')
@section('manageuser', 'active')

<style>
    #alerts {
        position: relative;
        animation-name: example;
        animation-duration: 0.7s;
        animation-iteration-count: 1;
        /* animation-delay: 2s; */
    }

    @keyframes example {
        0% {
            left: 200px;
            top: 0px;
        }

        100% {
            left: 0px;
            top: 0px;
        }
    }
</style>

{{-- tolong coba cari tau gmn connect css file
    harusnya pake ini <link rel="stylesheet" href="{{ asset('css/master.css') }}">, tapi gak tau knp ga bisa
    https://stackoverflow.com/questions/33988896/where-to-put-css-file-in-laravel-project --}}

{{-- TEST ANIMATIONS
https://www.w3schools.com/cssref/sel_id.php
https://www.w3schools.com/css/css3_animations.asp --}}

{{-- kalo mau seluruh block notificationnya berwarna, ga warna putih doang, pake ini di css inlinenya, style="background-color:yellow", terserah warnanya --}}

<div class="main-panel">
    <div class="content">
        <div class="page-inner">

            @if (session('sukses_delete'))
                <div class="alert alert-warning alert-block" id="alerts">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ session('sukses_delete') }}</strong>
                </div>
            @elseif (session('sukses_editUser'))
                <div class="alert alert-primary alert-block" id="alerts">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>informasi user "{{ session('sukses_editUser') }}" telah diubah</strong>
                </div>
            @elseif ($errors->any())
                <div class="alert alert-danger alert-block" id="alerts">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Update Failed, validation not met, error is: </strong>

                    @if ($errors->first() == 'The usernameformupdate must be at least 4 characters.')
                        <span class="text-danger">The edited username must be at least 4 characters.</span>
                    @elseif ($errors->first() == 'The usernameformupdate must not be greater than 16 characters.')
                        <span class="text-danger">The edited username must not be greater than 16 characters.</span>
                    @elseif ($errors->first() == 'The usernameformupdate has already been taken.')
                        <span class="text-danger">The edited username has already been taken</span>
                    @endif

                </div>
            @endif



            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Manage User Accounts</h4>
                                {{-- <a href="\exportExcel" class="btn btn-primary ml-3">EXPORT EXCEL</a> --}}
                                <button type="button" class="btn btn-primary ml-3" data-target="#exportuserModal"
                                    data-toggle="modal"><strong>EXPORT EXCEL</strong></button>

                                <div class="modal fade" id="exportuserModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">
                                                    Print Website Users</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="/exportExcel">
                                                    @csrf

                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="userLabelExport">Roles to Export</label>
                                                            <select class="form-control" id="userLabelExport"
                                                                name="userLevel">
                                                                <option value="admin">admin</option>
                                                                <option value="gudang">gudang</option>
                                                                <option value="all">SEMUA USER</option>
                                                            </select>

                                                            <label for="startRange">Start Date Range</label>
                                                            <input type="date" class="form-control" id="startRange"
                                                                required name="startRange">
                                                            <label for="endRange">End Date Range</label>
                                                            <input type="date" class="form-control" id="endRange"
                                                                required name="endRange">
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="card mt-5 ">
                                                                <button id="" class="btn btn-primary">Export
                                                                    Data</button>
                                                            </div>
                                                        </div>
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
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Account Role</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Account Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>

                                        @foreach ($user as $data)
                                            <tr>
                                                <td>{{ $data->name }}</td>
                                                <td>{{ $data->email }}</td>
                                                <td>{{ $data->level }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a style="cursor: pointer"
                                                            data-target="#editModalCenter{{ $data->id }}"
                                                            data-toggle="modal"><i class="fa fa-edit mt-3 text-primary"
                                                                data-toggle="tooltip" data-original-title="edit user">
                                                            </i></a>

                                                        @if (auth()->user()->id == $data->id)
                                                            <a class="ml-3" style="cursor: pointer">
                                                                <i class="fas fa-user mt-3 text-danger"
                                                                    data-toggle="tooltip"
                                                                    data-original-title="Cannot delete yourself">
                                                                </i>
                                                            </a>
                                                        @else
                                                            {{-- <a href="/deleteUser/{{ $data->id }}">
                                                        <i class="fa fa-times mt-3 text-danger"
                                                            data-toggle="tooltip" data-original-title="Delete User">
                                                        </i>
                                                    </a> --}}

                                                            {{-- ini -pake style cursor pake pointer buat efek hover. knp gak pake href kyk diatas? soalnya href bisa ngasihtau linknya dibawah gt, linknya tuh bisa berisi data penting, jadinya jgn pake itu kalo buttons
                                                        https://www.w3schools.com/cssref/tryit.php?filename=trycss_cursor
                                                        tapi yg tombol delete aslinya yg di modal masih apke href, gak tau gmn caranya biar delete ga pake href dan method "get" 5 --}}
                                                            <a class="ml-3" style="cursor: pointer"
                                                                data-target="#deleteModal{{ $data->id }}"
                                                                data-toggle="modal"><i
                                                                    class="fa fa-times mt-3 text-danger"
                                                                    data-toggle="tooltip"
                                                                    data-original-title="Delete User">
                                                                </i></a>
                                                        @endif
                                                    </div>

                                                    <div class="form-button-action">

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="editModalCenter{{ $data->id }}"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="exampleModalCenterTitle"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered"
                                                                role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h3 class="modal-title"
                                                                            id="exampleModalLongTitle">
                                                                            <strong>Update data for
                                                                                "{{ $data->name }}"</strong>
                                                                        </h3>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form method="post" action="/tex">
                                                                            @csrf
                                                                            <div class="card-body">
                                                                                <div class="form-group">
                                                                                    <label>Username</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        placeholder="enter new username"
                                                                                        aria-label=""
                                                                                        aria-describedby="basic-addon1"
                                                                                        name="usernameformupdate"
                                                                                        required>
                                                                                    <div class="card mt-5 ">
                                                                                        <button id=""
                                                                                            class="btn btn-primary">Update
                                                                                            Data</button>
                                                                                    </div>
                                                                                    {{-- @if ($errors->any())
                                                                                <span class="text-danger" id="editModalCenter{{ $data->id }}">{{ $errors->first() }}</span>
                                                                                <div class="alert alert-warning alert-block">
                                                                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                                                                    <strong>Update Failed, validation not met</strong>
                                                                                </div> --}}

                                                                                    {{-- ini gak tau knp errornya muncul dimodal semua user, sama ketutup gt modalnya, ga tau gmn caranya biar tetep kebuka pas refresh --}}
                                                                                    {{-- @endif --}}
                                                                                </div>

                                                                                <input type="hidden"
                                                                                    class="form-control"
                                                                                    name="userIdHidden"
                                                                                    value="{{ $data->id }}">
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    {{-- <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="button" class="btn btn-primary">Save
                                                                        changes</button>
                                                                </div> --}}
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <!-- Modal -->
                                                        {{-- <div class="modal fade" id="userUpdateModal" tabindex="-1"
                                                        role="dialog" aria-labelledby="exampleModalCenterTitle"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLongTitle">
                                                                        Modal title</h5>

                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form method="post" action="/tex">
                                                                    @csrf

                                                                    @yield('lemparID')

                                                                    <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <label>Username </label>
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Username" aria-label=""
                                                                                aria-describedby="basic-addon1"
                                                                                name="usernameform" required>
                                                                        </div>
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        {{-- ini gak tau knp tapi yg btn secondarynya yg buat nutup harus ditambahin "type="button"", terus yg dibawahnya yg buat save ngga. aneh bat dah. kalo ga gini ntar error 401 ato apa gt 1 --}}
                                                        {{-- <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                        <button class="btn btn-primary">Save
                                                                            changes</button> --}}
                                                        {{-- </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div> --}}

                                                        {{-- DIBAWAH INI CUMA BUAT PERCOBAAN DULU YG BUG FOREACH DATA CUMA KEBACA SEKALI DOANG. INI UDH BENER, NANTI DITERUSIN BESOK AE 2 --}}
                                                        {{-- <button type="button" class="btn btn-danger"
                                                            data-target="#deleteModal{{ $data->id }}"
                                                            data-toggle="modal">Delete
                                                            Item</button> --}}
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="deleteModal{{ $data->id }}">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="exampleModalLabel">
                                                                            <strong>PENGHAPUSAN USER</strong>
                                                                        </h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Apakah anda yakin untuk menghapus user
                                                                            {{ $data->name }}?</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-secondary" id="close-modal"
                                                                            data-dismiss="modal">Tidak</button>
                                                                        {{-- <button type="button"
                                                                            class="btn btn-danger">Yakin</button> --}}

                                                                        {{-- jadi kalo mau delete pake ini aja deh, jadi tombol href didalem modalnya, nah skrg yg aku mau itu gmn caranya tombol icon yang dari manage usernya bisa ngaktifin modal, tombol icon, bukan tombol kotaknya, terus yg href delete di modalnya baru tombol kotak  3 --}}

                                                                        <a href="/deleteUser/{{ $data->id }}"
                                                                            class="btn btn-danger">
                                                                            {{-- <i class="btn btn-danger"
                                                                                data-original-title="Delete User"> SETUJU
                                                                            </i> --}}YAKIN
                                                                        </a>

                                                                        {{-- UDAH BISA, DESAIN DALEM MODAL UDAH KYK GITU, BENER. tp yg iconnya yg diluar modal belom, sama tambahin delete notificationnya, kyk diatas gt, "user apalah telah berhasil didelete" 4 --}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
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
