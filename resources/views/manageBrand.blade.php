@extends('layout.layout')

@section('managebrandbutton', 'active')
@section('managebrand', 'active')
@section('showmanagebrand', 'show')

@section('content')
    <div class="main-panel">
        <div class="content">
            ini page buat manage brands
            <div class="page-inner">

                @if (session('sukses_delete_brand'))
                    <div class="alert alert-warning alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ session('sukses_delete_brand') }}</strong>
                    </div>
                @elseif (session('sukses_editBrand'))
                    <div class="alert alert-primary alert-block" id="alerts">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Sukses mengupdate data "{{ session('sukses_editBrand') }}"</strong>
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
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Manage Existing Brands</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="add-row" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Owner</th>
                                                <th>Brand ID</th>
                                                <th>Brand Name</th>
                                                <th style="width: 10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Owner</th>
                                                <th>Brand ID</th>
                                                <th>Brand Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>

                                            @foreach ($brand as $brand)
                                                <tr>
                                                    <td>{{ $brand->customer->customer_name }}</td>
                                                    <td>{{ $brand->brand_id }}</td>
                                                    <td>{{ $brand->brand_name }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <a style="cursor: pointer"
                                                                data-target="#editModalCenter{{ $brand->id }}"
                                                                data-toggle="modal">
                                                                <i class="fa fa-edit mt-3 text-primary"
                                                                    data-toggle="tooltip"
                                                                    data-original-title="Edit Brand"></i>
                                                            </a>
                                                            <a class="ml-3 mb-2" style="cursor: pointer"
                                                                data-target="#deleteModal{{ $brand->id }}"
                                                                data-toggle="modal">
                                                                <i class="fa fa-times mt-3 text-danger"
                                                                    data-toggle="tooltip"
                                                                    data-original-title="Delete Brand"></i>
                                                            </a>
                                                        </div>

                                                        <div class="modal fade" id="deleteModal{{ $brand->id }}">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            <strong>PENGHAPUSAN BRAND</strong>
                                                                        </h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Apakah anda yakin untuk menghapus brand
                                                                            "{{ $brand->brand_name }}" ?</p>
                                                                        <p>Jika dihapus, item dan stock yang dimiliki brand
                                                                            ini juga terhapus</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            id="close-modal"
                                                                            data-dismiss="modal">Tidak</button>
                                                                        <a href="/deleteBrand/{{ $brand->id }}"
                                                                            class="btn btn-danger">YAKIN
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal fade" id="editModalCenter{{ $brand->id }}"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLongTitle">
                                                                            Update data for "{{ $brand->brand_name }}"</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form method="post" action="/updateBrand">
                                                                            @csrf
                                                                            <div class="card-body">
                                                                                <div class="form-group">
                                                                                    <label>Brand Name</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        placeholder="brand name"
                                                                                        aria-label=""
                                                                                        aria-describedby="basic-addon1"
                                                                                        name="brandnameformupdate" required>
                                                                                    <div class="card mt-5 ">
                                                                                        <button id=""
                                                                                            class="btn btn-primary">Update
                                                                                            Data</button>
                                                                                    </div>
                                                                                </div>
                                                                                <input type="hidden" class="form-control"
                                                                                    name="brandIdHidden"
                                                                                    value="{{ $brand->id }}">
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
