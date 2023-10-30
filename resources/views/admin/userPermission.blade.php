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
                                                <strong>User "{{ $user->name }}" Page Permission </strong>
                                            </span>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col" style="width: 5%">#</th>
                                                <th scope="col">Page Menu and Their Pages</th>
                                                <th scope="col" style="width: 15%">Status/Edit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- bagian home --}}
                                            <tr>
                                                <th class="table-secondary" class="width:100%" scope="row">Menu: </th>
                                                <td class="table-secondary"><strong>Home</strong></td>
                                                <td class="table-secondary"></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Home</td>
                                                <td>
                                                    <a type="button" class="btn btn-success" style="cursor: pointer; width: 100px"
                                                        href="/manageHistory">Active</a>
                                                </td>
                                            </tr>
                                            {{-- kelola customer --}}
                                            <tr>
                                                <th class="table-secondary" class="width:100%" scope="row">Menu: </th>
                                                <td class="table-secondary"><strong>Kelola Customer</strong></td>
                                                <td class="table-secondary"></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Tambah Customer baru</td>
                                                <td>
                                                    <a type="button" class="btn btn-danger" style="cursor: pointer; width: 100px"
                                                        href="/manageHistory">Inactive</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>Data Customer</td>
                                                <td>
                                                    <a type="button" class="btn btn-danger" style="cursor: pointer; width: 100px"
                                                        href="/manageHistory">Inactive</a>
                                                </td>
                                            </tr>
                                            {{-- kelola brand --}}
                                            <tr>
                                                <th class="table-secondary" class="width:100%" scope="row">Menu: </th>
                                                <td class="table-secondary"><strong>Kelola  Brand</strong></td>
                                                <td class="table-secondary"></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Tambah Brand baru</td>
                                                <td>
                                                    <a type="button" class="btn btn-danger" style="cursor: pointer; width: 100px"
                                                        href="/manageHistory">Inactive</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>Data Brand</td>
                                                <td>
                                                    <a type="button" class="btn btn-danger" style="cursor: pointer; width: 100px"
                                                        href="/manageHistory">Inactive</a>
                                                </td>
                                            </tr>
                                            {{-- Kelola Barang --}}
                                            <tr>
                                                <th class="table-secondary" class="width:100%" scope="row">Menu: </th>
                                                <td class="table-secondary"><strong>Kelola Barang</strong></td>
                                                <td class="table-secondary"></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Laporan Stok by pcs</td>
                                                <td>
                                                    <a type="button" class="btn btn-danger" style="cursor: pointer; width: 100px"
                                                        href="/manageHistory">Inactive</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>Tambah Barang Baru</td>
                                                <td>
                                                    <a type="button" class="btn btn-danger" style="cursor: pointer; width: 100px"
                                                        href="/manageHistory">Inactive</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">3</th>
                                                <td>Data Barang</td>
                                                <td>
                                                    <a type="button" class="btn btn-danger" style="cursor: pointer; width: 100px"
                                                        href="/manageHistory">Inactive</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">4</th>
                                                <td>Barang Datang</td>
                                                <td>
                                                    <a type="button" class="btn btn-danger" style="cursor: pointer; width: 100px"
                                                        href="/manageHistory">Inactive</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">5</th>
                                                <td>Barang Keluar</td>
                                                <td>
                                                    <a type="button" class="btn btn-danger" style="cursor: pointer; width: 100px"
                                                        href="/manageHistory">Inactive</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">6</th>
                                                <td>History Stok by pcs</td>
                                                <td>
                                                    <a type="button" class="btn btn-danger" style="cursor: pointer; width: 100px"
                                                        href="/manageHistory">Inactive</a>
                                                </td>
                                            </tr>
                                            {{-- Kelola Barang --}}
                                            <tr>
                                                <th class="table-secondary" class="width:100%" scope="row">Menu: </th>
                                                <td class="table-secondary"><strong>Kelola Palet</strong></td>
                                                <td class="table-secondary"></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Laporan Stok by palet</td>
                                                <td>
                                                    <a type="button" class="btn btn-danger" style="cursor: pointer; width: 100px"
                                                        href="/manageHistory">Inactive</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>Palet Masuk</td>
                                                <td>
                                                    <a type="button" class="btn btn-danger" style="cursor: pointer; width: 100px"
                                                        href="/manageHistory">Inactive</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">3</th>
                                                <td>Palet Keluar</td>
                                                <td>
                                                    <a type="button" class="btn btn-success" style="cursor: pointer; width: 100px"
                                                        href="/manageHistory">Inactive</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">4</th>
                                                <td>History Stok by palet</td>
                                                <td>
                                                    <a type="button" class="btn btn-danger" style="cursor: pointer; width: 100px"
                                                        href="/manageHistory">Inactive</a>
                                                </td>
                                            </tr>
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
