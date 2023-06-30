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
                <div class="alert alert-warning alert-block" id="alertDelete">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ session('sukses_delete_customer') }}</strong>
                </div>
            @elseif (session('sukses_update_customer'))
                <div class="alert alert-success alert-block" id="alertSuccess">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ session('sukses_update_customer') }}</strong>
                </div>
            @elseif (session('noInput'))
                <div class="alert alert-danger alert-block" id="alertFailed">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ session('noInput') }}</strong>
                </div>
            @elseif (session('gagal_delete_customer'))
                <div class="alert alert-danger alert-block" id="alertFailed">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ session('gagal_delete_customer') }}</strong>
                </div>
            @elseif ($errors->any())
                <div class="alert alert-danger alert-block" id="alertFailed">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Update Gagal: {{ $errors->first() }} </strong>
                    {{-- <strong>Update Gagal: validasi tidak tercukupi, {{ $errors->first() }} </strong> --}}
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title"><strong>Mengelola Customer</strong></h4>
                                <a href="/exportCustomerExcel" class="btn btn-secondary ml-3"><strong>EXPORT KE
                                        EXCEL</strong></a>
                            </div>
                        </div>
                        <div class="card-body">
                            {{-- <div class="table-responsive"> --}}
                            <div class="table-responsive">
                                <table id="add-row" class="display table table-striped table-hover table-fixed">
                                    <thead>
                                        <tr>
                                            <th>ID Customer</th>
                                            <th>Nama Customer</th>
                                            <th>Alamat</th>
                                            <th>Email</th>
                                            <th>Telpon 1</th>
                                            <th>Telpon 2</th>
                                            <th>Fax</th>
                                            <th>Website</th>
                                            <th>Nama PIC</th>
                                            <th>PIC Nomor Telpon</th>
                                            <th>NPWP</th>
                                            <th style="width: 10%">Edit</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID Customer</th>
                                            <th>Nama Customer</th>
                                            <th>Address</th>
                                            <th>Email</th>
                                            <th>Telpon 1</th>
                                            <th>Telpon 2</th>
                                            <th>Fax</th>
                                            <th>Website</th>
                                            <th>Nama PIC</th>
                                            <th>PIC Nomor Telpon</th>
                                            <th>NPWP</th>
                                            <th>Edit</th>
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
                                                <td>{{ $data->website }} </td>
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
                                                        @if (App\Models\Brand::checkNullBrandCustomer($data->id) == 'kosong')
                                                            <a class="ml-3 mb-2" style="cursor: pointer"
                                                                data-target="#deleteModal{{ $data->id }}"
                                                                data-toggle="modal">
                                                                <i class="fa fa-times mt-3 text-danger"
                                                                    data-toggle="tooltip"
                                                                    data-original-title="Hapus Customer"></i>
                                                            </a>
                                                        @else
                                                            <a class="ml-3 mb-2" style="cursor: pointer">
                                                                <i class="fa fa-ban mt-3 text-danger"
                                                                    data-toggle="tooltip"
                                                                    data-original-title="Tidak bisa menghapus Customer karena sudah mempunyai Brand"></i>
                                                            </a>
                                                        @endif
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
                                                                    <a href="/deleteCustomer/{{ encrypt($data->id) }}"
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
                                                                    <div class="d-flex flex-column">
                                                                        <div class="p-2">
                                                                            <h3 class="modal-title"
                                                                                id="exampleModalLongTitle">
                                                                                <strong>Update data untuk
                                                                                    "{{ $data->customer_name }}"</strong>
                                                                            </h3>
                                                                        </div>
                                                                        <div class="p-2">
                                                                            <h5> Isi data yang ingin diubah</h5>
                                                                        </div>
                                                                    </div>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
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
                                                                                <label for="largeInput">Nama Customer
                                                                                </label>
                                                                                <input type="text"
                                                                                    class="form-control form-control"
                                                                                    placeholder="masukkan nama lengkap customer"
                                                                                    id="customername"
                                                                                    name="customername">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="largeInput">Alamat
                                                                                    Customer</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control"
                                                                                    placeholder="masukkan alamat customer"
                                                                                    id="address" name="address">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="email">Email
                                                                                    Customer</label>
                                                                                <input type="email"
                                                                                    class="form-control"
                                                                                    placeholder="masukkan email customer"
                                                                                    id="email" name="email">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="largeInput">Nomor Telpon 1
                                                                                    Customer</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control"
                                                                                    placeholder="(021)" id="phone1"
                                                                                    name="phone1">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="largeInput">Nomor Telpon 2
                                                                                    Customer</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control"
                                                                                    placeholder="+62" id="phone2"
                                                                                    name="phone2">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="largeInput">Nomor Fax
                                                                                    Customer</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control"
                                                                                    placeholder="(021)" id="fax"
                                                                                    name="fax">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="largeInput">Website
                                                                                    Customer</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control"
                                                                                    placeholder="Contoh: https://www.user.com"
                                                                                    id="website" name="website">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="largeInput">Nama PIC
                                                                                    (person in
                                                                                    charge)</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control"
                                                                                    placeholder="masukkan nama lengkap PIC"
                                                                                    id="picname" name="picname">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="largeInput">Nomor Telpon
                                                                                    PIC</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control"
                                                                                    placeholder="(021) atau +62"
                                                                                    id="picnumber" name="picnumber">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="largeInput">NPWP Nomor
                                                                                    Pokok Wajib Pajak</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control"
                                                                                    placeholder="contoh: 08.111.555.1-123.321"
                                                                                    id="npwp" name="npwp">
                                                                                <div class="card mt-5">
                                                                                    <button id=""
                                                                                        class="btn btn-primary">Update
                                                                                        Data Customer</button>
                                                                                </div>
                                                                                <div>
                                                                                    <h5 style="text-align: center;">
                                                                                        kolom
                                                                                        yang tidak diisi
                                                                                        akan menggunakan data yang
                                                                                        sebelumnya</h5>
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
</div>

@endsection
