@extends('layout.layout')


@section('managepalletbutton', 'active submenu') {{-- ini bagian folder nya --}}
@section('showmanagepallet', 'show') {{-- ini bagian folder nya yang buka tutup --}}
@section('outpallet', 'active') {{-- ini bagian button side panel yang di highlight nya --}}


@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <h4 class="page-title">Palet Keluar</h4>
                    <ul class="breadcrumbs">
                        <li class="nav-home">
                            <i class="flaticon-home"></i>
                        </li>
                        <li class="separator">
                            <i class="flaticon-right-arrow"></i>
                        </li>
                        <li class="separator">
                            <a>Kelola Palet</a>
                        </li>
                        <li class="separator">
                            <i class="flaticon-right-arrow"></i>
                        </li>
                        <li class="separator">
                            <a>Palet Keluar</a>
                        </li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title"><strong>Palet Keluar</strong></h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="add-row" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Customer</th>
                                                <th>Brand</th>
                                                <th>ID Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Stok</th>
                                                <th>BIN</th>
                                                <th>Tanggal Keluar</th>
                                                <th>Deskripsi</th>
                                                <th>Gambar</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Customer</th>
                                                <th>Brand</th>
                                                <th>ID Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Stok</th>
                                                <th>BIN</th>
                                                <th>Tanggal Keluar</th>
                                                <th>Deskripsi</th>
                                                <th style="width: 11%">Gambar</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>

                                            @foreach ($outpallet as $data)
                                                <tr>
                                                    <td>{{ $data->customer_name }}</td>
                                                    <td>{{ $data->brand_name }}</td>
                                                    <td>{{ $data->item_id }}</td>
                                                    <td>{{ $data->item_name }}</td>
                                                    <td>{{ $data->stock }}</td>
                                                    <td>{{ $data->bin }}</td>
                                                    <td>{{ date_format(date_create($data->user_date), 'd-m-Y') }}
                                                    <td>{{ $data->description }}</td>
                                                    <td>
                                                        <a style="cursor: pointer"
                                                            data-target="#imageModalCenter"
                                                            data-toggle="modal"
                                                            data-pic_url="{{ Storage::url($data->item_pictures) }}"
                                                            data-item_name="{{ $data->item_name }}">
                                                            <img class="rounded mx-auto d-block"
                                                                style="width: 100px; height: 50px; object-fit: cover;"
                                                                src="{{ Storage::url($data->item_pictures) }}"
                                                                alt="no picture" loading="lazy">
                                                        </a>
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

                {{-- FullSize Gambar --}}
                <div class="modal fade" id="imageModalCenter"
                    tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="padding: 0">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document"
                        style="min-width: auto; max-width: fit-content;">
                        <div class="modal-content" style="min-width:auto">
                            <div class="modal-header">
                                <h3 class="modal-title" id="exampleModalLongTitle" style="font-weight: bold"></h3>
                                <button type="button" class="close"
                                    data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body modal-img">
                                <img class="img-place rounded mx-auto d-block"
                                    style="height: 500px;  width:auto"
                                    src="#"
                                    alt="no picture" loading="lazy">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('#imageModalCenter').on('show.bs.modal', function(event) {
            $(".modal-img").css("padding", '0px');
            $(".modal-img").css("margin", '0px');
            var button = $(event.relatedTarget)
            var item_name = button.data('item_name')
            var pic_url = button.data('pic_url')
            var modal = $(this)


            modal.find('.modal-title').text('GAMBAR "' + item_name + '"')
            modal.find('.img-place').attr('src', pic_url)
        })
    </script>
@endsection
