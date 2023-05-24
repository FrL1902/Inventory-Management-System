@extends('layout.layout')

@section('content')

@section('managecustomerbutton', 'active')
@section('managecustomer', 'active')
@section('showmanagecustomer', 'show')


<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Manage Customer</h4>
                    </div>
                    <div class="card-body">
                        {{-- <div class="table-responsive"> --}}
                        <div class="table-responsive">
                            <table id="add-row" class="display table table-striped table-hover table-fixed">
                                <thead>
                                    <tr>
                                        <th>Customer ID</th>
                                        <th>Customer Name</th>
                                        <th>Address</th>
                                        <th>Email</th>
                                        <th>Phone 1</th>
                                        <th>Phone 2</th>
                                        <th>Fax</th>
                                        <th>Website</th>
                                        <th>PIC</th>
                                        <th>PIC Phone</th>
                                        <th>NPWP</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Customer ID</th>
                                        <th>Customer Name</th>
                                        <th>Address</th>
                                        <th>Email</th>
                                        <th>Phone 1</th>
                                        <th>Phone 2</th>
                                        <th>Fax</th>
                                        <th>Website</th>
                                        <th>PIC</th>
                                        <th>PIC Phone</th>
                                        <th>NPWP</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    @foreach ($customer as $data)
                                        <tr>
                                            <td>{{ $data->customer_id }}</td>
                                            <td>{{ $data->customer_name }}</td>
                                            <td>{{ $data->address }}</td>
                                            <td>{{ $data->email }}</td>
                                            <td>{{ $data->phone1 }}</td>
                                            <td>{{ $data->phone2 }}</td>
                                            <td>{{ $data->fax }}</td>
                                            <td>{{ $data->website }}</td>
                                            <td>{{ $data->pic }}</td>
                                            <td>{{ $data->pic_phone }}</td>
                                            <td>{{ $data->npwp_perusahaan }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a style="cursor: pointer"
                                                        data-target="#editModalCenter{{ $data->id }}"
                                                        data-toggle="modal">
                                                        <i class="fa fa-edit mt-3 text-primary" data-toggle="tooltip"
                                                            data-original-title="Edit Customer"></i>
                                                    </a>
                                                    <a class="ml-2" style="cursor: pointer"
                                                        data-target="#deleteModal{{ $data->id }}"
                                                        data-toggle="modal">
                                                        <i class="fa fa-times mt-3 text-danger" data-toggle="tooltip"
                                                            data-original-title="Delete Customer"></i>
                                                    </a>
                                                </div>
                                                <div class="modal fade" id="deleteModal{{ $data->id }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">
                                                                    <strong>PENGHAPUSAN CUSTOMER</strong>
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Apakah anda yakin untuk menghapus customer
                                                                    "{{ $data->customer_name }}" ?</p>
                                                                    <p>Jika dihapus, brand dan item yang dimiliki customer ini juga terhapus</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    id="close-modal" data-dismiss="modal">Tidak</button>
                                                                <a href="/deleteCustomer/{{ $data->id }}"
                                                                    class="btn btn-danger">YAKIN
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="editModalCenter{{ $data->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle">
                                                                    Update data for "{{ $data->customer_name }}"</h5>
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
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Username" aria-label=""
                                                                                aria-describedby="basic-addon1"
                                                                                name="usernameformupdate" required>
                                                                            <div class="card mt-5 ">
                                                                                <button id=""
                                                                                    class="btn btn-primary">Update
                                                                                    Data</button>
                                                                            </div>
                                                                        </div>

                                                                        <input type="hidden" class="form-control"
                                                                            name="userIdHidden"
                                                                            value="{{ $data->id }}">
                                                                    </div>
                                                                </form>
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

@endsection
