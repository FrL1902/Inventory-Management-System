@extends('layout.layout')


@section('manageitembutton', 'active submenu') {{-- ini bagian folder nya --}}
@section('showmanageitem', 'show') {{-- ini bagian folder nya yang buka tutup --}}
@section('itemreport', 'active') {{-- ini bagian button side panel yang di highlight nya --}}

@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                {{-- Disini customer bisa melihat posisi palet untuk setiap barang secara langsung --}}
                <div class="page-header">
                    <h4 class="page-title">Laporan Stok by pcs</h4>
                    <ul class="breadcrumbs">
                        <li class="nav-home">
                            <i class="flaticon-home"></i>
                        </li>
                        <li class="separator">
                            <i class="flaticon-right-arrow"></i>
                        </li>
                        <li class="separator">
                            <a>Kelola Barang</a>
                        </li>
                        <li class="separator">
                            <i class="flaticon-right-arrow"></i>
                        </li>
                        <li class="separator">
                            <a>Laporan Stok by pcs</a>
                        </li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">
                                        Laporan Barang
                                    </h4>
                                    <div class="dropdown ml-3">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false"> <i class="fa fa-file-excel" aria-hidden="true"></i>
                                            Export Berdasarkan
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" data-target="#exportItemReportCustomerModal"
                                                data-toggle="modal">Customer</a>
                                            <a class="dropdown-item" data-target="#exportItemReportBrandModal"
                                                data-toggle="modal">Brand</a>
                                            <a class="dropdown-item" data-target="#exportItemReportItemModal"
                                                data-toggle="modal">Barang</a>
                                        </div>
                                    </div>

                                    {{-- export by CUSTOMER --}}
                                    <div class="modal fade" id="exportItemReportCustomerModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form method="post" action="/exportItemReportCustomer">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h3 class="modal-title" id="exampleModalLongTitle">
                                                            <strong>
                                                                EXPORT LAPORAN BERDASARKAN CUSTOMER
                                                            </strong>
                                                        </h3>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    {{-- export by customer name --}}
                                                    <div class="modal-body" style="padding:0">
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="customerIdItemReport" class="mb-1"
                                                                    style="font-weight: bold">Customer</label>
                                                                <select class="form-control" data-width="100%"
                                                                    id="customerIdItemReport" name="customerIdItemReport"
                                                                    required="required">

                                                                    <option></option>
                                                                    @foreach ($customer as $data)
                                                                        <option value="{{ $data->customer_id }}">
                                                                            {{ $data->customer_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-primary">Export
                                                            Data</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- export by BRAND --}}
                                    <div class="modal fade" id="exportItemReportBrandModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLongTitle">
                                                        <strong>
                                                            EXPORT LAPORAN BERDASARKAN BRAND
                                                        </strong>
                                                    </h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                {{-- export by brand name --}}
                                                <form method="post" action="/exportItemReportBrand">
                                                    @csrf
                                                    <div class="modal-body" style="padding:0">
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="brandIdItemReport"
                                                                    style="font-weight: bold">Brand</label>
                                                                <select class="form-control" data-width="100%"
                                                                    id="brandIdItemReport" name="brandIdItemReport"
                                                                    required>
                                                                    <option></option>
                                                                    @foreach ($brand as $data)
                                                                        <option value="{{ $data->brand_id }}">
                                                                            {{ $data->brand_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-primary">Export
                                                            Data</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- export by ITEM --}}
                                    <div class="modal fade" id="exportItemReportItemModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLongTitle">
                                                        <strong>
                                                            EXPORT LAPORAN BERDASARKAN BARANG
                                                        </strong>
                                                    </h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                {{-- export by item name --}}
                                                <form method="post" action="/exportItemReportItem">
                                                    @csrf
                                                    <div class="modal-body" style="padding:0">
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="itemIdItemReport" class="mb-1"
                                                                    style="font-weight: bold">Item</label>
                                                                <select class="form-control" data-width="100%"
                                                                    id="itemIdItemReport" name="itemIdItemReport"
                                                                    required>
                                                                    <option></option>
                                                                    @foreach ($item as $data)
                                                                        <option value="{{ $data->item_id }}">
                                                                            {{ $data->item_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-primary">Export
                                                            Data</button>
                                                    </div>
                                                </form>
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
                                                <th>Customer</th>
                                                <th>Brand</th>
                                                <th>ID Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Stok</th>
                                                <th>Tanggal</th>
                                                <th>Tanggal Terakhir Diupdate</th>
                                                <th style="width: 11%">Gambar</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Customer</th>
                                                <th>Brand</th>
                                                <th>ID Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Stok</th>
                                                <th>Tanggal</th>
                                                <th>Tanggal Terakhir Diupdate</th>
                                                <th>Gambar</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($item as $item)
                                                <tr>
                                                    <td>{{ $item->customer_name }}</td>
                                                    <td>{{ $item->brand_name }}</td>
                                                    <td>{{ $item->item_id }}</td>
                                                    <td>{{ $item->item_name }}</td>
                                                    <td>{{ $item->stocks }}</td>
                                                    <td>{{ $item->created_at }}</td>
                                                    <td>{{ $item->updated_at }}</td>
                                                    <td>
                                                        <a style="cursor: pointer" data-target="#imageModalCenter"
                                                            data-toggle="modal"
                                                            data-pic_url="{{ Storage::url($item->item_pictures) }}"
                                                            data-item_name="{{ $item->item_name }}">
                                                            <img class="rounded mx-auto d-block" {{-- style="width: 100px; height: auto;" --}}
                                                                style="width: 100px; height: 50px; object-fit: cover;"
                                                                src="{{ Storage::url($item->item_pictures) }}"
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
                <div class="modal fade" id="imageModalCenter" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="padding: 0">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document"
                        style="min-width: auto; max-width: fit-content;">
                        <div class="modal-content" style="min-width:auto">
                            <div class="modal-header">
                                <h3 class="modal-title" id="exampleModalLongTitle" style="font-weight: bold"></h3>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body modal-img">
                                <img class="img-place rounded mx-auto d-block" style="height: 500px;  width:auto"
                                    src="#" alt="no picture" loading="lazy">
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
