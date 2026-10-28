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
            <h4 class="page-title"> <span class="page-title-icon bg-gradient-primary text-white me-2"><i class="fa fa-home" aria-hidden="true"></i></span> Publish Book </h4>
           </div>
        </div>
      </div>
    </div>
  </section>
<section class="book-publish mt-5 mb-5">
  <div class="container">
  <div class="row form-box">
    <div class="col-md-6 bg-img"></div>
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
      <h3>Publish Your Book</h3>
    <form action="<?php echo base_url() ?>AuthorDashboard/bookPublish" id="myform" method="post">
    @csrf
    <div class="mb-3">
    <input type="hidden" name="id" value="<?php echo $userid ; ?>">

    <label for="exampleInputEmail1" class="form-label">Book Title </label>
    <input type="text" class="form-control" name="book_title" id="book_title" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="disabledSelect" class="form-label">Status of Manuscript</label>
      <select id="Select" name="status_of_manuscript" class="form-select">
        <option value="" selected="true" disabled="disabled">Select</option>
        <option value="completed">Completed</option>
        <option value="inprocess">In Process</option>
      </select>
</div>
    <div class="mb-3">
    <label for="disabledSelect" class="form-label">Genre of Book</label>
      <select name="book_genre" class="form-control" id="book_genre">
        <option value="">Select</option>
        <option  value="Fiction">Fiction</option>
        <option value="Non-Fiction">Non-Fiction</option>
        <option value="Poetry">Poetry</option>
        <option value="Academics">Academics</option>
        <option  value="Children Book">Children's Book</option>
        <option  value="Others">Others</option>
      </select>
    </div>
    <div class="mb-3">
    <label for="disabledSelect" class="form-label">Book Language</label>
      <select id="Select1" name="book_language" class="form-select">
      <option value="" selected="true" disabled="disabled">Select</option>
      <?php foreach($book_language as $language) {?>
      <option value="<?php echo $language->id; ?>"><?php echo $language->name ?></option>
       <?php }?>
       </select>
    </div>
    <div class="mb-3">
                            <input type="checkbox" name="checkbox" id="checkbox" required>
                                <span class="checkbox_content">I, hereby accord my consent to process my above mentioned personal data by BFC Publications Pvt. Ltd. for the purpose of Author support/Service Promotion, in accordance with the provisions of DPDP Act 2023.</span>
                            <br>
                            <span class="checkbox_content" id="check_box_err_payment"> </span>
                        </div>
   <div class="d-flex justify-content-end mt-5">
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
  $("#myform").validate({
        rules: {
          book_title:{ required:true },
          status_of_manuscript: { required: true },
          book_genre: { required: true },
          book_language: { required: true }
        },
          messages: {
          book_title: "Please enter our book title",
          status_of_manuscript: "Please select status of manuscript",
          book_genre:  "Please select book genre",
          book_language: "Please select book language"
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
