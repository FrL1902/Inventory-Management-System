@extends('layout.layout')

@section('content')

@section('manageuserbutton', 'active')
@section('showmanageuser', 'show')
@section('manageuser', 'active')

<div class="main-panel">
    <div class="content">
        ini buat manage user / udah bisa view, ga tau tombol editnya enaknya buat apa
        <div class="page-inner">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Manage User Accounts</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="add-row" class="display table table-striped table-hover" >
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
                                            <td>{{$data->name}}</td>
                                            <td>{{$data->email}}</td>
                                            <td>{{$data->level}}</td>
                                            <td>
                                                <div class="form-button-action">
                                                    <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit User">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    @if (auth()->user()->id == $data->id)
                                                        <a href="#">
                                                            <i class="fas fa-user mt-3 text-danger" data-toggle="tooltip" data-original-title="Cannot delete yourself">
                                                            </i>
                                                        </a>
                                                    @else
                                                        <a href="/deleteUser/{{$data->id}}">
                                                            <i class="fa fa-times mt-3 text-danger" data-toggle="tooltip" data-original-title="Delete User">
                                                            </i>
                                                        </a>
                                                    @endif
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
@endsection
