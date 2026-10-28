@extends('layouts.app')

@section('content')
<div class="content-wrapper">
 <section class="breadcrumb-nav pt-4 breadcrumb-bg pt-70 mt-4">
    <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="page-header">
            <h4 class="page-title"> <span class="page-title-icon bg-gradient-primary text-white me-2"><i class="fa fa-home" aria-hidden="true"></i></span> Change Password  </h4>
           </div>
        </div>
      </div>
    </div>
  </section>

<section class="change-pwd mt-5">
  <div class="container">
  <div class="row form-box1">
    <div class="col-md-6">
       <img src="<?php echo base_url() ?>authordashboard/assets/img/change-pwd.jpg" class="img-fluid">
    </div>

    <div class="col-md-6">
       <div class="form-section">
      @if(!empty(session('error_msg')))
      <div class="alert alert-danger">
      <strong>Error!</strong> {!! session('error_msg') !!}
      </div>
      @endif
      @if(!empty(session('success_msg')))
      <div class="alert alert-success">
      <strong>Success!</strong> {!! session('success_msg') !!}
      </div>
      @endif

      <h3 class="">Change Your Password</h3>
      <div class="">
      <?php $user = session('author_login')['user_id'] ?>

    <form id="register-form" action="<?php echo base_url() ?>AuthorDashboard/updatePass" method="post">
    @csrf
    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Enter Current Password</label>
    <input type="hidden" name="userid" value="<?php echo $user ?>" class="form-control" >
    <input type="password" name="oldPassword" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    {!! form_error('oldPassword') !!}
    {!! session('Oldpassword') !!}
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Enter New Password</label>
    <input type="password" name="newPassword" class="form-control" id="newPassword">
    {!! form_error('newPassword') !!}
  </div>
   <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
    <input type="password" name="confirm_pass" class="form-control" id="exampleInputPassword">
    {!! form_error('confirm_pass') !!}
  </div>
  <button type="submit" name="submit" class="custom-btn mt-2">Change Password</button>
  </form>
</div>
    </div>
     </div>
  </div>
</div>
</section>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $("#register-form").validate({
        rules: {
          oldPassword: "required",
          newPassword: {
                required: true,
            },
             confirm_pass: {
                required: true,
                equalTo : "#newPassword",
             },
        },
        messages: {
          oldPassword: "Please enter current Password",
          newPassword: {
                required: "Please enter new  password",
            },
          confirm_pass: {
                 required: "Please enter confirm  password",
                 equalTo : "Password does not match .",
          },
        },
         errorPlacement: function(error, element) {
            if ( element.is(":radio") ) {
                error.appendTo( element.parents('.form-group') );
            } else {
                error.insertAfter( element );
            }
         },
        submitHandler: function(form) {
            form.submit();
        }
    });
    window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove();
      });
    }, 4000)
});
</script>
@endsection
