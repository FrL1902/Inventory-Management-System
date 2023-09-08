@extends('layout.layout')


@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex flex-row">
                                        <h4 class="card-title mt-1 mr-3">
                                            <span class="align-middle">
                                                <strong>User Access "{{ $user->name }}" To Customer</strong>
                                            </span>
                                        </h4>
                                        <button type="button" class="btn btn-primary ml-3 mr-3"
                                            data-target="#addUserAccess" data-toggle="modal"><strong>ADD</strong></button>
                                    </div>
                                    <div class="modal fade" id="addUserAccess" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="exampleModalLongTitle">
                                                        <strong>
                                                            Tambahkan Customer yang bisa diakses oleh "{{ $user->name }}"
                                                        </strong>
                                                    </h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="/addNewUserAccess">
                                                        @csrf

                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="customerforaccess">Nama Customer</label>
                                                                <select class="form-control" data-width="100%"
                                                                    id="customerforaccess" name="customerforaccess">
                                                                    @foreach ($customer as $data)
                                                                        <option value="{{ $data->id }}">
                                                                            {{ $data->customer_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <input type="hidden" class="form-control" name="userIdHidden"
                                                                value="{{ $user->id }}">

                                                            <div class="form-group">
                                                                <div class="card mt-5 ">
                                                                    <button id="" class="btn btn-primary">Insert
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
                                                <th>Customer Name</th>
                                                <th style="width: 20%">Customer ID</th>
                                                <th style="width: 10%">Edit</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Customer Name</th>
                                                <th style="width: 20%">Customer ID</th>
                                                <th style="width: 10%">Edit</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($access as $data)
                                                <tr>
                                                    <td>{{ $data->customer_name }}</td>
                                                    <td>{{ $data->customer_id }}</td>
                                                    <td>edit</td>
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
