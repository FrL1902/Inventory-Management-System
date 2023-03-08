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
                                    </tr>
                                </tfoot>
                                <tbody>

                                    @foreach ($customer as $data)

                                        <tr>
                                            <td>{{$data->customer_id}}</td>
                                            <td>{{$data->customer_name}}</td>
                                            <td>{{$data->address}}</td>
                                            <td>{{$data->email}}</td>
                                            <td>{{$data->phone1}}</td>
                                            <td>{{$data->phone2}}</td>
                                            <td>{{$data->fax}}</td>
                                            <td>{{$data->website}}</td>
                                            <td>{{$data->pic}}</td>
                                            <td>{{$data->pic_phone}}</td>
                                            <td>{{$data->npwp_perusahaan}}</td>
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
