
<?php include 'layout/header.php' ?>

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
            <div class="col-md-6 bg-refer"  style="background-image: url('<?php echo base_url();?>/authordashboard/assets/img/refer-a-friend.jpg');">
          <!-- <img src="<?php echo base_url()?>authordashboard/assets/img/refer-a-friend.jpg"> -->
          </div>
            <div class="col-md-6">
              <div class="form-section">
              <?php if(!empty($this->session->flashdata('success_msg'))){?>
      <div class="alert alert-success">
      <strong>Success!</strong> <?php echo $this->session->flashdata('success_msg');?>
      </div>
      <?php }?>
      <?php if(!empty($this->session->flashdata('error_msg'))){?>
      <div class="alert alert-danger">
      <strong>Error!</strong> <?php echo $this->session->flashdata('success_msg');?>
      </div>
      <?php }?>
                <h3>Refer a Friend</h3>
             
                <form  action="<?php base_url() ?>refer_friend_info" id="form_id" name="form_id" method="post">
                  <div class="mb-3">
                    <input type="hidden" name="id" value="<?php echo $userid ; ?>">
                    <label for="exampleInputEmail1" class="form-label">Name </label>
                    <input type="text" class="form-control" name="user_name" id="user_name" aria-describedby="emailHelp" >
                    <?php echo form_error('user_name'); ?>
                  </div>

                  <div class="mb-3">
                   <label for="exampleInputEmail1" class="form-label">Email </label>
                    <input type="email" class="form-control" name="user_email" id="user_email" aria-describedby="emailHelp" >
                    <?php echo form_error('user_email'); ?>
                  </div>
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Phone No. </label>
                    <input type="number" class="form-control" name="user_mobile" id="user_mobile" aria-describedby="emailHelp">
                    <?php echo form_error('user_mobile'); ?>
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
      <?php include 'layout/footer.php' ?>
      
    </body>
  </html> 

  <script>
   
$(document).ready(function(){
  
  $("#form_id").validate(
      {
        rules: {
          user_name: {
                required:true,
               
            },                    
           
            user_email: {
                required:true,
                email: true
         
            },
            user_mobile:{
              required: true,
              maxlength: 10,
              minlength: 10,
            },
          },

          messages: {
                  
            user_name: {
                required: "Please enter  name",
               
            },          
           
                  
            user_email: {
                required: "Please enter  email",
                email: "Please enter  valid email",
       
               
            },

            user_mobile:{
              required: "Please enter  mobile no.",
              maxlength: "Incorrect mobile number",
              minlength: "Incorrect mobile number",
             
            },
         
        },
                 errorPlacement: function(error, element) 
        {
            if ( element.is(":radio") ) 
            {
                error.appendTo( element.parents('.form-group') );
            }
            else 
            { // This is the default behavior 
                error.insertAfter( element );
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