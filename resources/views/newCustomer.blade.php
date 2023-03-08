@extends('layout.layout')

@section('content')

@section('managecustomerbutton', 'active')
@section('newcustomer', 'active')
@section('showmanagecustomer', 'show')


<div class="main-panel">
    <div class="content">
        ini page buat add new customer

        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <form method="post" action="/makeCustomer">
                            @csrf
                            <div class="card-header">
                                <div class="card-title">Add New Customer</div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="largeInput">Customer ID</label>
                                    <input type="text" class="form-control form-control" placeholder="ex. CU001" id="customerid" name="customerid">
                                </div>
                                <div class="form-group">
                                    <label for="largeInput">Customer Name</label>
                                    <input type="text" class="form-control form-control" placeholder="Enter customer's full name" id="customername" name="customername">
                                </div>
                                <div class="form-group">
                                    <label for="largeInput">Customer Address</label>
                                    <input type="text" class="form-control form-control" placeholder="Enter customer's address" id="address" name="address">
                                </div>
                                <div class="form-group">
                                    <label for="email">Customer Email</label>
                                    <input type="email" class="form-control" placeholder="Enter Email" id="email" name="email">
                                </div>
                                <div class="form-group">
                                    <label for="largeInput">Customer Work Phone Number</label>
                                    <input type="text" class="form-control form-control" placeholder="(021)" id="phone1" name="phone1">
                                </div>
                                <div class="form-group">
                                    <label for="largeInput">Customer Personal Phone Number</label>
                                    <input type="text" class="form-control form-control" placeholder="+62" id="phone2" name="phone2">
                                </div>
                                <div class="form-group">
                                    <label for="largeInput">Customer Fax</label>
                                    <input type="text" class="form-control form-control" placeholder="(021)" id="fax" name="fax">
                                </div>
                                <div class="form-group">
                                    <label for="largeInput">Customer's website</label>
                                    <input type="text" class="form-control form-control" placeholder="https://www.user.com" id="website" name="website">
                                </div>
                                <div class="form-group">
                                    <label for="largeInput">PIC person in charge</label>
                                    <input type="text" class="form-control form-control"  placeholder="Enter PIC's full name" id="picname" name="picname">
                                </div>
                                <div class="form-group">
                                    <label for="largeInput">PIC phone number</label>
                                    <input type="text" class="form-control form-control"  placeholder="Enter PIC's phone number" id="picnumber" name="picnumber">
                                </div>
                                <div class="form-group">
                                    <label for="largeInput">NPWP Perusahaan Nomor Pokok Wajib Pajak</label>
                                    <input type="text" class="form-control form-control" placeholder="ex. 08.178.554.2-123.321" id="npwp" name="npwp">
                                </div>
                                <div class="card mt-4">
                                    <button class="btn btn-success">Insert New User</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
