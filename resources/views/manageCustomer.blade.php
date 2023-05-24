@extends('layout.layout')

@section('content')

@section('managecustomerbutton', 'active')
@section('managecustomer', 'active')
@section('showmanagecustomer', 'show')


<div class="main-panel">
    <div class="content">
        {{-- @if ($errors->any())
            @foreach ($errors->all() as $err)
                <li class="text-danger">{{ $err }}</li>
            @endforeach
        @endif --}}
        <div class="page-inner">
            @if (session('sukses_delete_customer'))
                <div class="alert alert-warning alert-block" id="alerts">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ session('sukses_delete_customer') }}</strong>
                </div>
            @elseif (session('sukses_update_customer'))
                <div class="alert alert-primary alert-block" id="alerts">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ session('sukses_update_customer') }}</strong>
                </div>
            @elseif ($errors->any())
                <div class="alert alert-danger alert-block" id="alerts">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Update Failed, validation not met</strong>
                </div>
            @endif
            <div class="row">
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
                                                            <i class="fa fa-edit mt-3 text-primary"
                                                                data-toggle="tooltip"
                                                                data-original-title="Edit Customer"></i>
                                                        </a>
                                                        <a class="ml-2" style="cursor: pointer"
                                                            data-target="#deleteModal{{ $data->id }}"
                                                            data-toggle="modal">
                                                            <i class="fa fa-times mt-3 text-danger"
                                                                data-toggle="tooltip"
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
                                                                    <p>Jika dihapus, brand dan item yang dimiliki
                                                                        customer
                                                                        ini juga terhapus</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        id="close-modal"
                                                                        data-dismiss="modal">Tidak</button>
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
                                                                        Update data for "{{ $data->customer_name }}"
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>isi data yang ingin di update</p>
                                                                    <p>data tidak akan berubah jika tidak diisi</p>
                                                                    <form method="post" action="/updateCustomer">
                                                                        @csrf
                                                                        <div class="card-body">
                                                                            {{-- <div class="form-group">
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
                                                                        </div> --}}

                                                                            <input type="hidden" class="form-control"
                                                                                name="customerIdHidden"
                                                                                value="{{ $data->id }}">


                                                                            {{-- <div class="row">
                                                                            <div class="col-sm">

                                                                              </div>
                                                                              <div class="col-sm">

                                                                              </div>
                                                                        </div> --}}
                                                                            <div class="form-group">
                                                                                <label for="largeInput">Customer
                                                                                    Address</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control"
                                                                                    placeholder="Enter customer's address"
                                                                                    id="address" name="address">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="largeInput">Customer
                                                                                    Personal
                                                                                    Phone Number</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control"
                                                                                    placeholder="+62" id="phone2"
                                                                                    name="phone2">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="largeInput">Customer
                                                                                    Fax</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control"
                                                                                    placeholder="(021)" id="fax"
                                                                                    name="fax">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="largeInput">Customer's
                                                                                    website</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control"
                                                                                    placeholder="https://www.user.com"
                                                                                    id="website" name="website">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="largeInput">PIC person in
                                                                                    charge</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control"
                                                                                    placeholder="Enter PIC's full name"
                                                                                    id="picname" name="picname">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="largeInput">PIC phone
                                                                                    number</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control"
                                                                                    placeholder="Enter PIC's phone number"
                                                                                    id="picnumber" name="picnumber">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="largeInput">NPWP Perusahaan
                                                                                    Nomor Pokok Wajib Pajak</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control"
                                                                                    placeholder="ex. 08.178.554.2-123.321"
                                                                                    id="npwp" name="npwp">
                                                                            </div>
                                                                            <button id=""
                                                                                class="btn btn-primary">Update
                                                                                Data</button>

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
</div>

@endsection
