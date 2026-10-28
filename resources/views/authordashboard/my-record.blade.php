@extends('layouts.app')

@section('content')
<div class="content-wrapper">

  <section class="breadcrumb-nav mb-2 mt-5 pt-5">
    <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="page-header">
            <h4 class="page-title"> <span class="page-title-icon bg-gradient-primary text-white me-2"><i class="fa fa-home" aria-hidden="true"></i></span> My Record </h4>
           </div>
        </div>
      </div>
    </div>
  </section>

<section class="pb-5 pt-5">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="my-record-btn text-center">
          <img src="<?php echo base_url() ?>authordashboard/assets/img/application.png" class="img-fluid mb-4" >
        <h4>Author Submission Form</h4>
        <a href="#" class="custom-btn"> No file found</a>
      </div>
    </div>
    <div class="col-md-4">
        <div class="my-record-btn text-center">
          <img src="<?php echo base_url() ?>authordashboard/assets/img/agreement.png" class="img-fluid mb-4" >
        <h4>Agreement</h4>
        <a href="#" class="custom-btn"> No file found</a>
      </div>
    </div>
    <div class="col-md-4">
        <div class="my-record-btn text-center">
          <img src="<?php echo base_url() ?>authordashboard/assets/img/bank.png" class="img-fluid mb-4" >
        <h4>View Bank Details</h4>
        <a href="bank_details" class="custom-btn" data-toggle="modal" data-target="#staticBackdrop"> View Bank Details</a>
      </div>
    </div>
  </div>
</div>
</section>

</div>


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Bank Account Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form>
        <div class="form-data">
          <h3>Banking Information</h3>
          <p>Please provide valid Indian Bank Account Details. NRI/NRE accounts will not be accepted.</p>
        </div>
       <div class="form-row justify-content-between">
      <div class="form-group col-md-6">
      <label for="inputEmail4">Beneficiary Name </label>
      <input type="email" class="form-control" id="inputEmail4" placeholder="Account Name">
    </div>
    <div class="form-group col-md-5">
      <label for="inputPassword4">Beneficiary Account Number </label>
      <input type="password" class="form-control" id="inputPassword4" placeholder="Account Holder Name">
    </div>
    <div class="form-group col-md-6">
      <label for="inputState">Banking Country</label>
      <select id="inputState" class="form-control">
        <option selected>India</option>
        <option>Italy</option>
      </select>
    </div>
    <div class="form-group col-md-5">
      <label for="inputZip">Bank Name </label>
      <input type="text" class="form-control" id="inputZip" placeholder="Bank Name">
    </div>
    <div class="form-group col-md-6">
      <label for="inputZip">Branch Name </label>
      <input type="text" class="form-control" id="inputZip" placeholder="Branch Name">
    </div>
    <div class="form-group col-md-5">
      <label for="inputZip">Beneficiary IFSC Code  </label>
      <input type="text" class="form-control" id="inputZip" placeholder="Bank IFSC Code">
    </div>
  </div>
          <div class="form-data mt-4 mb-4">
          <h3>Tax Information</h3>
          <p>Scan/Take a photo of your cancelled cheque Leaf and PAN card, upload it here.</p>
        </div>

      <div class="form-row justify-content-between">
      <div class="form-group col-md-3">
      <label for="inputEmail4">PAN Card Number </label>
      <input type="email" class="form-control" id="inputEmail4" placeholder="AAAPL1234C">
    </div>
    <div class="form-group col-md-4">
      <label for="inputPassword4">Upload PAN Card </label>
      <input type="file" class="form-control" id="inputPassword4">
    </div>
    <div class="form-group col-md-4">
      <label for="inputState">Upload Cancelled Cheque Leaf</label>
     <input type="file" class="form-control" id="inputPassword4">
    </div>
  </div>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="custom-btn">Save changes</button>
      </div>
    </div>
  </div>
</div>


<!-- Profile Modal -->
<div class="modal fade" id="profile" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">My Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-30">
        <div class="row profile-img mb-4">
          <div class="col-md-12 text-center">
            <img src="<?php echo base_url() ?>authordashboard/assets/img/user.png" class="img-fluid">
          </div>
        </div>
       <div class="row profile">
        <div class="col-md-4"><h3 class="fw-400">Full Name :</h3></div>
        <div class="col-md-8"><h3>Sharad Bindal</h3></div>
      </div>
      <div class="row profile ">
        <div class="col-md-4"><h3 class="fw-400">Email :</h3></div>
        <div class="col-md-8"><h3>SHARADBINDAL@BFCCAPITAL.COM</h3></div>
      </div>
      <div class="row profile">
        <div class="col-md-4"><h3 class="fw-400">Mobile :</h3></div>
        <div class="col-md-8"><h3>+91 9792202239</h3></div>
      </div>
      <div class="row profile">
        <div class="col-md-4"><h3 class="fw-400">Address :</h3></div>
        <div class="col-md-8"><h3>CP - 61 Viraj Khand, Gomti Nagar, Lucknow - 226010</h3></div>
      </div>
      <div class="row profile">
        <div class="col-md-4"><h3 class="fw-400">Nominee :</h3></div>
        <div class="col-md-8"><h3>Mrs. Deepti Bindal</h3></div>
      </div>
      </div>

      <div class="modal-footer"></div>
    </div>
  </div>
</div>


<!-- Change Pwd Modal -->
<div class="modal fade" id="change-pwd" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Change Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-30">
      <form>
  <div class="form-group">
    <label for="exampleFormControlInput1">Enter Current Password</label>
    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Current Password">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Enter New Password</label>
    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder=" New Password">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Confirm Password</label>
    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Confirm Password">
  </div>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="custom-btn">Change Password</button>
      </div>
    </div>
  </div>
</div>
@endsection
