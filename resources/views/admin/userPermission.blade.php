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
                                            {{-- kelola customer --}}
                                            <tr>
                                                <th class="table-secondary" class="width:100%" scope="row">Menu: </th>
                                                <td class="table-secondary">
                                                    <i class="fa fa-users mr-2"></i>
                                                    <strong>Kelola Customer</strong>
                                                </td>
                                                <td class="table-secondary"></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Tambah Customer baru</td>
                                                @if (App\Models\UserPermission::checkPageStatus($user->name, 'tambah_customer_baru') == 1) {{-- change ini --}}
                                                    <td>
                                                        <form method="post" action="/permissionToFalse">
                                                            @csrf

                                                            <button class="btn btn-success"
                                                                style="cursor: pointer; width: 100px">Active</button>

                                                            <input type="hidden" name="page" value="tambah_customer_baru"> {{-- change ini --}}
                                                            <input type="hidden" name="name" value={{ $user->name }}>
                                                        </form>
                                                    </td>
                                                @else
                                                    <td>
                                                        <form method="post" action="/permissionToTrue">
                                                            @csrf
                                                            <button class="btn btn-danger"
                                                                style="cursor: pointer; width: 100px">Inactive</button>

                                                            <input type="hidden" name="page" value="tambah_customer_baru"> {{-- change ini --}}
                                                            <input type="hidden" name="name" value={{ $user->name }}>
                                                        </form>
                                                    </td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>Data Customer</td>
                                                @if (App\Models\UserPermission::checkPageStatus($user->name, 'data_customer') == 1) {{-- change ini --}}
                                                    <td>
                                                        <form method="post" action="/permissionToFalse">
                                                            @csrf

                                                            <button class="btn btn-success"
                                                                style="cursor: pointer; width: 100px">Active</button>

                                                            <input type="hidden" name="page" value="data_customer"> {{-- change ini --}}
                                                            <input type="hidden" name="name" value={{ $user->name }}>
                                                        </form>
                                                    </td>
                                                @else
                                                    <td>
                                                        <form method="post" action="/permissionToTrue">
                                                            @csrf
                                                            <button class="btn btn-danger"
                                                                style="cursor: pointer; width: 100px">Inactive</button>

                                                            <input type="hidden" name="page" value="data_customer"> {{-- change ini --}}
                                                            <input type="hidden" name="name" value={{ $user->name }}>
                                                        </form>
                                                    </td>
                                                @endif
                                            </tr>
                                            {{-- kelola brand --}}
                                            <tr>
                                                <th class="table-secondary" class="width:100%" scope="row">Menu: </th>
                                                <td class="table-secondary">
                                                    <i class="fa fa-th-large mr-2"></i>
                                                    <strong>Kelola Brand</strong>
                                                </td>
                                                <td class="table-secondary"></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Tambah Brand baru</td>
                                                @if (App\Models\UserPermission::checkPageStatus($user->name, 'tambah_brand_baru') == 1) {{-- change ini --}}
                                                    <td>
                                                        <form method="post" action="/permissionToFalse">
                                                            @csrf

                                                            <button class="btn btn-success"
                                                                style="cursor: pointer; width: 100px">Active</button>

                                                            <input type="hidden" name="page" value="tambah_brand_baru"> {{-- change ini --}}
                                                            <input type="hidden" name="name" value={{ $user->name }}>
                                                        </form>
                                                    </td>
                                                @else
                                                    <td>
                                                        <form method="post" action="/permissionToTrue">
                                                            @csrf
                                                            <button class="btn btn-danger"
                                                                style="cursor: pointer; width: 100px">Inactive</button>

                                                            <input type="hidden" name="page" value="tambah_brand_baru"> {{-- change ini --}}
                                                            <input type="hidden" name="name" value={{ $user->name }}>
                                                        </form>
                                                    </td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>Data Brand</td>
                                                @if (App\Models\UserPermission::checkPageStatus($user->name, 'data_brand') == 1) {{-- change ini --}}
                                                    <td>
                                                        <form method="post" action="/permissionToFalse">
                                                            @csrf

                                                            <button class="btn btn-success"
                                                                style="cursor: pointer; width: 100px">Active</button>

                                                            <input type="hidden" name="page" value="data_brand"> {{-- change ini --}}
                                                            <input type="hidden" name="name" value={{ $user->name }}>
                                                        </form>
                                                    </td>
                                                @else
                                                    <td>
                                                        <form method="post" action="/permissionToTrue">
                                                            @csrf
                                                            <button class="btn btn-danger"
                                                                style="cursor: pointer; width: 100px">Inactive</button>

                                                            <input type="hidden" name="page" value="data_brand"> {{-- change ini --}}
                                                            <input type="hidden" name="name" value={{ $user->name }}>
                                                        </form>
                                                    </td>
                                                @endif
                                            </tr>
                                            {{-- Kelola Barang --}}
                                            <tr>
                                                <th class="table-secondary" class="width:100%" scope="row">Menu: </th>
                                                <td class="table-secondary">
                                                    <i class="fa fa-truck mr-2"></i>
                                                    <strong>Kelola Barang</strong>
                                                </td>
                                                <td class="table-secondary"></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Laporan Stok by pcs</td>
                                                @if (App\Models\UserPermission::checkPageStatus($user->name, 'laporan_stok_by_pcs') == 1) {{-- change ini --}}
                                                    <td>
                                                        <form method="post" action="/permissionToFalse">
                                                            @csrf

                                                            <button class="btn btn-success"
                                                                style="cursor: pointer; width: 100px">Active</button>

                                                            <input type="hidden" name="page" value="laporan_stok_by_pcs"> {{-- change ini --}}
                                                            <input type="hidden" name="name" value={{ $user->name }}>
                                                        </form>
                                                    </td>
                                                @else
                                                    <td>
                                                        <form method="post" action="/permissionToTrue">
                                                            @csrf
                                                            <button class="btn btn-danger"
                                                                style="cursor: pointer; width: 100px">Inactive</button>

                                                            <input type="hidden" name="page" value="laporan_stok_by_pcs"> {{-- change ini --}}
                                                            <input type="hidden" name="name" value={{ $user->name }}>
                                                        </form>
                                                    </td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>Tambah Barang Baru</td>
                                                @if (App\Models\UserPermission::checkPageStatus($user->name, 'tambah_barang_baru') == 1) {{-- change ini --}}
                                                    <td>
                                                        <form method="post" action="/permissionToFalse">
                                                            @csrf

                                                            <button class="btn btn-success"
                                                                style="cursor: pointer; width: 100px">Active</button>

                                                            <input type="hidden" name="page" value="tambah_barang_baru"> {{-- change ini --}}
                                                            <input type="hidden" name="name" value={{ $user->name }}>
                                                        </form>
                                                    </td>
                                                @else
                                                    <td>
                                                        <form method="post" action="/permissionToTrue">
                                                            @csrf
                                                            <button class="btn btn-danger"
                                                                style="cursor: pointer; width: 100px">Inactive</button>

                                                            <input type="hidden" name="page" value="tambah_barang_baru"> {{-- change ini --}}
                                                            <input type="hidden" name="name" value={{ $user->name }}>
                                                        </form>
                                                    </td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">3</th>
                                                <td>Data Barang</td>
                                                @if (App\Models\UserPermission::checkPageStatus($user->name, 'data_barang') == 1) {{-- change ini --}}
                                                    <td>
                                                        <form method="post" action="/permissionToFalse">
                                                            @csrf

                                                            <button class="btn btn-success"
                                                                style="cursor: pointer; width: 100px">Active</button>

                                                            <input type="hidden" name="page" value="data_barang"> {{-- change ini --}}
                                                            <input type="hidden" name="name" value={{ $user->name }}>
                                                        </form>
                                                    </td>
                                                @else
                                                    <td>
                                                        <form method="post" action="/permissionToTrue">
                                                            @csrf
                                                            <button class="btn btn-danger"
                                                                style="cursor: pointer; width: 100px">Inactive</button>

                                                            <input type="hidden" name="page" value="data_barang"> {{-- change ini --}}
                                                            <input type="hidden" name="name" value={{ $user->name }}>
                                                        </form>
                                                    </td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">4</th>
                                                <td>Barang Datang</td>
                                                @if (App\Models\UserPermission::checkPageStatus($user->name, 'barang_datang') == 1) {{-- change ini --}}
                                                    <td>
                                                        <form method="post" action="/permissionToFalse">
                                                            @csrf

                                                            <button class="btn btn-success"
                                                                style="cursor: pointer; width: 100px">Active</button>

                                                            <input type="hidden" name="page" value="barang_datang"> {{-- change ini --}}
                                                            <input type="hidden" name="name" value={{ $user->name }}>
                                                        </form>
                                                    </td>
                                                @else
                                                    <td>
                                                        <form method="post" action="/permissionToTrue">
                                                            @csrf
                                                            <button class="btn btn-danger"
                                                                style="cursor: pointer; width: 100px">Inactive</button>

                                                            <input type="hidden" name="page" value="barang_datang"> {{-- change ini --}}
                                                            <input type="hidden" name="name" value={{ $user->name }}>
                                                        </form>
                                                    </td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">5</th>
                                                <td>Barang Keluar</td>
                                                @if (App\Models\UserPermission::checkPageStatus($user->name, 'barang_keluar') == 1) {{-- change ini --}}
                                                    <td>
                                                        <form method="post" action="/permissionToFalse">
                                                            @csrf

                                                            <button class="btn btn-success"
                                                                style="cursor: pointer; width: 100px">Active</button>

                                                            <input type="hidden" name="page" value="barang_keluar"> {{-- change ini --}}
                                                            <input type="hidden" name="name" value={{ $user->name }}>
                                                        </form>
                                                    </td>
                                                @else
                                                    <td>
                                                        <form method="post" action="/permissionToTrue">
                                                            @csrf
                                                            <button class="btn btn-danger"
                                                                style="cursor: pointer; width: 100px">Inactive</button>

                                                            <input type="hidden" name="page" value="barang_keluar"> {{-- change ini --}}
                                                            <input type="hidden" name="name" value={{ $user->name }}>
                                                        </form>
                                                    </td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">6</th>
                                                <td>History Stok by pcs</td>
                                                @if (App\Models\UserPermission::checkPageStatus($user->name, 'history_stok_by_pcs') == 1) {{-- change ini --}}
                                                    <td>
                                                        <form method="post" action="/permissionToFalse">
                                                            @csrf

                                                            <button class="btn btn-success"
                                                                style="cursor: pointer; width: 100px">Active</button>

                                                            <input type="hidden" name="page" value="history_stok_by_pcs"> {{-- change ini --}}
                                                            <input type="hidden" name="name" value={{ $user->name }}>
                                                        </form>
                                                    </td>
                                                @else
                                                    <td>
                                                        <form method="post" action="/permissionToTrue">
                                                            @csrf
                                                            <button class="btn btn-danger"
                                                                style="cursor: pointer; width: 100px">Inactive</button>

                                                            <input type="hidden" name="page" value="history_stok_by_pcs"> {{-- change ini --}}
                                                            <input type="hidden" name="name" value={{ $user->name }}>
                                                        </form>
                                                    </td>
                                                @endif
                                            </tr>
                                            {{-- Kelola Palet --}}
                                            <tr>
                                                <th class="table-secondary" class="width:100%" scope="row">Menu: </th>
                                                <td class="table-secondary">
                                                    <i class="fa fa-archive mr-2"></i>
                                                    <strong>Kelola Palet</strong>
                                                </td>
                                                <td class="table-secondary"></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Laporan Stok by palet</td>
                                                @if (App\Models\UserPermission::checkPageStatus($user->name, 'laporan_stok_by_palet') == 1) {{-- change ini --}}
                                                    <td>
                                                        <form method="post" action="/permissionToFalse">
                                                            @csrf

                                                            <button class="btn btn-success"
                                                                style="cursor: pointer; width: 100px">Active</button>

                                                            <input type="hidden" name="page" value="laporan_stok_by_palet"> {{-- change ini --}}
                                                            <input type="hidden" name="name" value={{ $user->name }}>
                                                        </form>
                                                    </td>
                                                @else
                                                    <td>
                                                        <form method="post" action="/permissionToTrue">
                                                            @csrf
                                                            <button class="btn btn-danger"
                                                                style="cursor: pointer; width: 100px">Inactive</button>

                                                            <input type="hidden" name="page" value="laporan_stok_by_palet"> {{-- change ini --}}
                                                            <input type="hidden" name="name" value={{ $user->name }}>
                                                        </form>
                                                    </td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>Palet Masuk</td>
                                                @if (App\Models\UserPermission::checkPageStatus($user->name, 'palet_masuk') == 1) {{-- change ini --}}
                                                    <td>
                                                        <form method="post" action="/permissionToFalse">
                                                            @csrf

                                                            <button class="btn btn-success"
                                                                style="cursor: pointer; width: 100px">Active</button>

                                                            <input type="hidden" name="page" value="palet_masuk"> {{-- change ini --}}
                                                            <input type="hidden" name="name" value={{ $user->name }}>
                                                        </form>
                                                    </td>
                                                @else
                                                    <td>
                                                        <form method="post" action="/permissionToTrue">
                                                            @csrf
                                                            <button class="btn btn-danger"
                                                                style="cursor: pointer; width: 100px">Inactive</button>

                                                            <input type="hidden" name="page" value="palet_masuk"> {{-- change ini --}}
                                                            <input type="hidden" name="name" value={{ $user->name }}>
                                                        </form>
                                                    </td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">3</th>
                                                <td>Palet Keluar</td>
                                                @if (App\Models\UserPermission::checkPageStatus($user->name, 'palet_keluar') == 1) {{-- change ini --}}
                                                    <td>
                                                        <form method="post" action="/permissionToFalse">
                                                            @csrf

                                                            <button class="btn btn-success"
                                                                style="cursor: pointer; width: 100px">Active</button>

                                                            <input type="hidden" name="page" value="palet_keluar"> {{-- change ini --}}
                                                            <input type="hidden" name="name" value={{ $user->name }}>
                                                        </form>
                                                    </td>
                                                @else
                                                    <td>
                                                        <form method="post" action="/permissionToTrue">
                                                            @csrf
                                                            <button class="btn btn-danger"
                                                                style="cursor: pointer; width: 100px">Inactive</button>

                                                            <input type="hidden" name="page" value="palet_keluar"> {{-- change ini --}}
                                                            <input type="hidden" name="name" value={{ $user->name }}>
                                                        </form>
                                                    </td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">4</th>
                                                <td>History Stok by palet</td>
                                                @if (App\Models\UserPermission::checkPageStatus($user->name, 'history_stok_by_palet') == 1) {{-- change ini --}}
                                                    <td>
                                                        <form method="post" action="/permissionToFalse">
                                                            @csrf

                                                            <button class="btn btn-success"
                                                                style="cursor: pointer; width: 100px">Active</button>

                                                            <input type="hidden" name="page" value="history_stok_by_palet"> {{-- change ini --}}
                                                            <input type="hidden" name="name" value={{ $user->name }}>
                                                        </form>
                                                    </td>
                                                @else
                                                    <td>
                                                        <form method="post" action="/permissionToTrue">
                                                            @csrf
                                                            <button class="btn btn-danger"
                                                                style="cursor: pointer; width: 100px">Inactive</button>

                                                            <input type="hidden" name="page" value="history_stok_by_palet"> {{-- change ini --}}
                                                            <input type="hidden" name="name" value={{ $user->name }}>
                                                        </form>
                                                    </td>
                                                @endif
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
