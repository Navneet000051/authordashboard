@extends('layouts.app')

@section('head')
<style>
    .checkbox_content {
            font-size: 14px;
            font-weight: 400;
        }
</style>
@endsection

@section('content')
    <div class="content-wrapper mt-5 pt-5">
      <section class="breadcrumb-nav pt-4 breadcrumb-bg">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="page-header">
                <h4 class="page-title"> <span class="page-title-icon bg-gradient-primary text-white me-2"><i class="fa fa-home" aria-hidden="true"></i></span> Refer a Friend </h4>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="book-publish mt-5 mb-5">
        <div class="container">
          <div class="row form-box">
            <div class="col-md-6 bg-refer"  style="background-image: url('<?php echo base_url();?>authordashboard/assets/img/refer-a-friend.jpg');">
          </div>
            <div class="col-md-6">
              <div class="form-section">
              @if(!empty(session('success_msg')))
      <div class="alert alert-success">
      <strong>Success!</strong> {!! session('success_msg') !!}
      </div>
      @endif
      @if(!empty(session('error_msg')))
      <div class="alert alert-danger">
      <strong>Error!</strong> {!! session('error_msg') !!}
      </div>
      @endif
                <h3>Refer a Friend</h3>

                <form  action="<?php echo base_url() ?>AuthorDashboard/refer_friend_info" id="form_id" name="form_id" method="post">
                  @csrf
                  <div class="mb-3">
                    <input type="hidden" name="id" value="<?php echo $userid ; ?>">
                    <label for="exampleInputEmail1" class="form-label">Name </label>
                    <input type="text" class="form-control" name="user_name" id="user_name" aria-describedby="emailHelp" >
                    {!! form_error('user_name') !!}
                  </div>

                  <div class="mb-3">
                   <label for="exampleInputEmail1" class="form-label">Email </label>
                    <input type="email" class="form-control" name="user_email" id="user_email" aria-describedby="emailHelp" >
                    {!! form_error('user_email') !!}
                  </div>
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Phone No. </label>
                    <input type="number" class="form-control" name="user_mobile" id="user_mobile" aria-describedby="emailHelp">
                    {!! form_error('user_mobile') !!}
                    </div>
                    <div class="mb-3">
                            <input type="checkbox" name="checkbox" id="checkbox" required>
                                <span class="checkbox_content">I, hereby accord my consent to process my above mentioned personal data by BFC Publications Pvt. Ltd. for the purpose of Author support/Service Promotion, in accordance with the provisions of DPDP Act 2023.</span>
                            <br>
                            To know more <a href="https://bfcpublications.com/DPDP_Act" target="_blank">click here</a>
                            <br>
                            <span class="text-danger" id="check_box_err_payment"> </span>
                        </div>
                    <div class=" mt-5">
                      <button type="submit" class="custom-btn px-5">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
@endsection

@section('scripts')
  <script>
$(document).ready(function(){
  $("#form_id").validate({
        rules: {
          user_name: { required:true },
            user_email: { required:true, email: true },
            user_mobile:{ required: true, maxlength: 10, minlength: 10 },
          },
          messages: {
            user_name: { required: "Please enter  name" },
            user_email: { required: "Please enter  email", email: "Please enter  valid email" },
            user_mobile:{ required: "Please enter  mobile no.", maxlength: "Incorrect mobile number", minlength: "Incorrect mobile number" },
        },
                 errorPlacement: function(error, element) {
            if ( element.is(":radio") ) {
                error.appendTo( element.parents('.form-group') );
            } else {
                error.insertAfter( element );
            }
            if (element.attr("name") == "checkbox") {
        error.appendTo("#check_box_err_payment");
    } else {
        error.insertAfter(element);
    }
         },
                submitHandler: function(form) {
                    form.submit();
                }
            });
    });

      window.setTimeout(function() {
  $(".alert").fadeTo(800, 0).slideUp(200, function(){
      $(this).remove();
  });
}, 4000);
  </script>
@endsection
