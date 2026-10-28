<?php include 'layout/header.php' ?>

<style>
  .profilebook .form-select{
    font-size: 18px;
    font-weight: 500;
    font-family: 'Poppins', sans-serif;
    color: #c54952;
  }
  .md-40{
    max-width: 40px;
  }
</style>
<div class="">

<section class="breadcrumb-nav breadcrumb-bg pt-5 mt-5 pt-70">
    <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="page-header">
            <h4 class="page-title"> <span class="page-title-icon bg-gradient-primary text-white me-2"><i class="fa fa-home" aria-hidden="true"></i></span> My Profile </h4>
           </div>
        </div>
      </div>
    </div>
  </section>


<section class="pt-4">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <?php if($asf_details->profile_pic_url=='') { ?>

     
        <div id="image" style="background: center center url('<?php echo base_url().'assets/no-user-image-icon-27.jpg';?>');background-size: 105%; background-repeat: no-repeat; ">
        </div>

      <?php }else{ ?>

        <div id="image" style="background: center center url('<?php echo $asf_details->profile_pic_url?>');background-size: 105%; background-repeat: no-repeat; ">
        </div>

      <?php }?>
        <div class="social-icon">
          <ul class="d-flex list-unstyled justify-content-center">
            <li><a href="" class="icon"><img src="<?php echo base_url() ?>authordashboard/assets/img/facebook.png" class="img-fluid md-40"></a></li>
            <li><a href="" class="icon"><img src="<?php echo base_url() ?>authordashboard/assets/img/instagram.png" class="img-fluid md-40"></a></li>
            <li><a href="" class="icon"><img src="<?php echo base_url() ?>authordashboard/assets/img/linkedin.png" class="img-fluid md-40"></a></li>
            <li><a href="" class="icon"><img src="<?php echo base_url() ?>authordashboard/assets/img/twitter.png" class="img-fluid md-40"></a></li>
          </ul>
        </div>
      </div>
      <div class="col-md-8 d-flex align-items-stretch">
        <div class="align-self-center"> 
        <div class="author-text"> 

          <h3><?php echo $this->session->userdata('author_login')['userName']; ?> </h3>
          <p><?php echo $asf_details->asf_authorbio ?></p>
          <div class="d-flex">
            <div class="toolti"><img src="<?php echo base_url() ?>authordashboard/assets/img/gmail.png" class="img-fluid  md-30"></a>
            <span class="tooltitext">Email </span></div>
            <h6 class="pt-1 ps-3 pb-2"><?php echo $this->session->userdata('author_login')['email'] ?></h6>
          </div>
          <div class="d-flex">
            <div class="toolti"><img src="<?php echo base_url() ?>authordashboard/assets/img/call.png" class="img-fluid  md-30"></a>
            <span class="tooltitext">Mobile </span></div>
            <h6 class="pt-1 ps-3 pb-2">+91 <?php echo $this->session->userdata('author_login')['mobileNo'] ?> </h6>
          </div>

         
          <div class="d-flex">
            <div class="toolti"><img src="<?php echo base_url() ?>authordashboard/assets/img/google-maps.png" class="img-fluid  md-30">
             <span class="tooltitext">Location </span></div>
            <?php if($asf_details->asf_address!=''){ ?>
              <h6 class="pt-1 ps-3 pb-2"><?php echo $asf_details->asf_address.", ". $asf_details->asf_landmark .", ". $asf_details->asf_city.", ".$asf_details->asf_country.", ".$asf_details->asf_state.", ".$asf_details->pincode ?>  </h6>
            <?php } ?>
          </div>
          
          <div class="d-flex">
           <div class="toolti"><img src="<?php echo base_url() ?>authordashboard/assets/img/nomination.png" class="img-fluid  md-30"></a>
            <span class="tooltitext">Nominee </span></div>
            <h6 class="pt-1 ps-3 pb-2"><?php echo $asf_details->asf_nomineename ?> </h6>
          </div>
          <?php if($this->session->userdata('author_login')['lead_new']=='1'){?>
          <div class="d-flex">
           <div class="toolti pe-2"><img src="<?php echo base_url() ?>authordashboard/assets/img/demo-book.png" class="img-fluid md-40"></a>
            <span class="tooltitext">Select Book </span></div>
            <div class="profilebook w-50">
            <select class="form-select" id="book_id" onchange="myprofile();">
            <option value="">Select</option>
            <?php if(!empty($book_details)){
               foreach($book_details as $value){
                if(!empty($value->book_title)){
              ?>
            <option <?php if(!empty($id==$value->id)) echo 'selected';?> value="<?php echo $value->id;?>" data-new="<?php echo $value->lead_new;?>" data-id="<?php echo $value->lead_id;?>" ><?php echo $value->book_title;?></option>
            <?php }}}?>
          </select>
        </div> 
          </div>
          <?php }?>
      </div>
      </div>
    </div>
  </div>
</section>
<?php if($this->session->userdata('author_login')['lead_new']=='1'){?>
<section class="mt-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-7 mb-4">
        <nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Published Books</button>
    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">View ASF Details</button>
    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Agreement</button>
  </div>
</nav>
      </div>
        <hr/>
        <div class="col-md-12">
   <div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
     <div class="row mt-5">
      <!-- <div class="col-md-2">
         <img src="<?php echo base_url() ?>authordashboard/assets/img/book-img.jpeg" class="img-fluid ">
      </div>
      <div class="col-md-2">
         <img src="<?php echo base_url() ?>authordashboard/assets/img/book-img.jpeg" class="img-fluid ">
      </div>
      <div class="col-md-2">
         <img src="<?php echo base_url() ?>authordashboard/assets/img/book-img.jpeg" class="img-fluid ">
      </div>
      <div class="col-md-2">
         <img src="<?php echo base_url() ?>authordashboard/assets/img/book-img.jpeg" class="img-fluid ">
      </div>
      <div class="col-md-2">
         <img src="<?php echo base_url() ?>authordashboard/assets/img/book-img.jpeg" class="img-fluid ">
      </div>
      <div class="col-md-2">
         <img src="<?php echo base_url() ?>authordashboard/assets/img/book-img.jpeg" class="img-fluid ">
      </div> -->
    </div>
  </div>
  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"> 
     <div class="row mt-5">
    <div class="col-md-12">
        <div class="">
        <p></p>
        <?php if(!empty($package_details->asf_pdf_data)){?>
          <embed src="https://bfcgroup.in/assets/asf_authorMail/<?php echo $package_details->asf_pdf_data;?>" style="width: 100%;height: 460px;border: none;">
          <?php }else{?>  
      <p>No Record Found</p>
      <?php }?> 
        </div>
      </div>
    </div>
  </div>
  <div class="tab-pane mb-5 fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
     <div class="row mt-5">
     <div class="col-md-12">
        <div class="">
          <p><?php //echo $agreement ?></p>
          <?php if(!empty($package_details->pdf_mail_agreement)){?>
     <embed src="https://bfcgroup.in/assets/asf_agreementMail/<?php echo $package_details->pdf_mail_agreement;?>" style="width: 100%;height: 460px;border: none;">
     <?php }elseif(!empty($package_details->final_mail_agreement_upload)){?>
     <embed src="https://bfcgroup.in/assets/asf_agreementMail/<?php echo $package_details->final_mail_agreement_upload;?>" style="width: 100%;height: 460px;border: none;">
  
     <?php }else{?>  
      <p>No Record Found</p>
      <?php }?>  
    </div>
      </div>
    </div>
  </div>
</div>
</div>
       
      </div>
    </div>
  </div>
</section>
<?php }?>
</div>

<?php include 'layout/footer.php' ?>

<script>
  function myprofile(){
     var lead_id=$("#book_id").val();
     var selected = $("#book_id").find('option:selected');
     var id = selected.data('id');
     var lead_new = selected.data('new');
     window.location.href = "<?php echo base_url();?>AuthorDashboard/myprofile/"+lead_id+'/'+id+'/'+lead_new;
  }
</script>
  </body>
</html>