@extends('layouts.app')

@section('content')
    <div class="content-wrapper mt-5 pt-5">
      <section class="breadcrumb-nav pt-4 breadcrumb-bg">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="page-header">
                <h4 class="page-title"> <span class="page-title-icon bg-gradient-primary text-white me-2"><i class="fa fa-home" aria-hidden="true"></i></span> Bank Details </h4>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="book-publish mt-5 mb-5">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="bank-form">
                <h3>Banking Information</h3>
                <p>Please provide valid Indian Bank Account Details. NRI/NRE accounts will not be accepted.</p>

              <form class="row mt-5" >
              <div class=" col-md-4 mb-3">
              <label for="exampleInputEmail1" class="form-label">Beneficiary Name</label>
              <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Account Name">
            </div>
            <div class="col-md-4 mb-3">
              <label for="exampleInputPassword1" class="form-label">Beneficiary Account Number</label>
              <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Account Number">
            </div>
            <div class="col-md-4 mb-3">
               <label for="disabledSelect" class="form-label">Banking Country </label>
                <select id="Select" class="form-select">
                  <option value="" selected="true" disabled="disabled">Select</option>
                  <option value="completed">India</option>
                  <option value="inprocess">China</option>
                </select>
            </div>
             <div class="col-md-4 mb-3">
              <label for="exampleInputPassword1" class="form-label">Bank Name</label>
              <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Bank Name">
            </div>

            <div class="col-md-4 mb-3">
              <label for="exampleInputPassword1" class="form-label">Branch Name</label>
              <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Branch Name">
            </div>

            <div class="col-md-4 mb-3">
              <label for="exampleInputPassword1" class="form-label">Beneficiary IFSC Code </label>
              <input type="password" class="form-control" id="exampleInputPassword1" placeholder="SBIN0C2B5N8">
            </div>

                <h3 class="mt-4">Tax Information</h3>
                <p class="mb-5">Scan/Take a photo of your cancelled cheque Leaf and PAN card, upload it here.</p>

             <div class="col-md-4 mb-3">
              <label for="exampleInputPassword1" class="form-label">PAN Card Number</label>
              <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Bank Name">
            </div>

            <div class="col-md-4 mb-3">
              <label for="exampleInputPassword1" class="form-label">Upload PAN Card</label>
               <input class="form-control" type="file" id="formFile">
            </div>

            <div class="col-md-4 mb-3">
              <label for="exampleInputPassword1" class="form-label">Upload Cancelled Cheque Leaf </label>
               <input class="form-control" type="file" id="formFile">
            </div>

             <div class="col-md-4 mb-3">
            <button type="submit" class="custom-btn mt-4">Save Changes</button>
          </div>
            </form>
              </div>
            </div>
          </div>
      </section>
      </div>
@endsection
