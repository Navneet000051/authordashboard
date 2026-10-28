@extends('frontend.layout.app')
@section('title','Payment')
@section('content')




<style type="text/css">
#footer-content{
    display:none;
}
.horizontal-menu-wrapper{
    display:none;
}
   /* Style inputs with type="text", select elements and textareas */
   input[type=text], select, textarea {
   width: 100%; /* Full width */
   padding: 12px; /* Some padding */  
   border: 1px solid #ccc; /* Gray border */
   border-radius: 4px; /* Rounded borders */
   box-sizing: border-box; /* Make sure that padding and width stays in place */
   margin-top: 6px; /* Add a top margin */
   margin-bottom: 16px; /* Bottom margin */
   resize: vertical /* Allow the user to vertically resize the textarea (not horizontally) */
   }
   /* Style the submit button with a specific background color etc */
   input[type=submit] {
   background-color: #4CAF50;
   color: white;
   padding: 12px 20px;
   border: none;
   border-radius: 4px;
   cursor: pointer;
   }
   input[type=submit]:hover {
   background-color: #45a049;
   }
</style>
<div class="page-contact">
<div class="container">
   <div class="row">
       <div class="col-md-3"></div>
      <div class="col-md-9">
         <br/><br/>
         <h2>Welcome to our payment channel </h2>
         <br/>
      </div>
     
   </div>
   <div class="row">
      <div class="col-md-3" style="padding-bottom: 52px;"></div>
      <div class="col-md-6" style="padding: 0px 122px 0px 52px;border: 1px solid gray;">
         <form method="get" action="{{URL('paymentRequestnn')}}" id="contact_form" accept-charset="UTF-8" class="contact-form">
            @csrf
            <div class="form-group">
               <!--<label>App ID:</label><br>-->
               <!--<input type="hidden" class="form-control" name="appId" placeholder="Enter App ID here (Ex. 123456a7890bc123defg4567)" value="29787295c06f7f0b7dab18a0678792"/>-->
               <input type="hidden" class="form-control" name="appId" placeholder="" value="733936538bd77bb9b19ec42f039337"/>
            </div>
            <div class="form-group">
               
               <br/> 
               
                
            </div>
            <div class="form-group">
               <!--<label>Order ID:</label><br>-->
               <input type="hidden" class="form-control" name="packageName" placeholder="" value="packageNameOpen"/>
               <input type="hidden" class="form-control" name="subPackageName" placeholder="" value="subPackageNameOpen"/>
               <input type="hidden" class="form-control" name="orderId" id="orderId" placeholder="Enter Order ID here (Ex. order00001)" value="--"/>
            </div>
            <div class="form-group">
               <label><b>Enter Your Amount:</b></label><br>
               <input type="text" class="form-control" name="orderAmount" placeholder="Enter Order Amount here (Ex. 100)" value=""/>
            </div>
            <div class="form-group">
               <!--<label>Order Currency:</label><br>-->
               <input type="hidden" class="form-control" name="orderCurrency" value="INR" placeholder="Enter Currency here (Ex. INR)"/>
            </div>
            <div class="form-group">
               <!--<label>Order Note:</label><br>-->
               <input type="hidden" class="form-control" name="orderNote" placeholder="Enter Order Note here (Ex. Test order)"/>
            </div>
            <div class="form-group">
               <label><b>Name:</b></label><br>
               <input class="form-control" name="customerName" placeholder="Enter your name here" required />
            </div>
            <div class="form-group">
               <label><b>Email:</b></label><br>
               <!-- <input class="form-control" style="text-transform: lowercase" name="customerEmail" type="text" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="Enter your email address here" title="Email Id with a-z,A-Z,any No and remaing @gmail.com,@yahoo.com etc" required/> -->

               <input class="form-control" style="text-transform: lowercase" name="customerEmail" type="text" placeholder="Enter your email address here" title="Email Id with a-z,A-Z,any No and remaing @gmail.com,@yahoo.com etc" required/>
            </div>
            <div class="form-group">
               <label><b>Phone:</b></label><br>
               <input type="text" class="form-control" name="customerPhone"  placeholder="Enter your phone number here" maxlength="10" required/>
               <!--<input type="text" name="Phone Number" pattern="[7-9]{1}[0-9]{9}" 
                  title="Phone number with 7-9 and remaing 9 digit with 0-9" placeholder="Enter your phone no here" required>-->
            </div>
            <div class="form-group">
               <label><b>State:</b></label><br>
				<select class="form-control" name="state_name">
					<option>Select State</option>
               <option value="Andhra Pradesh">Andhra Pradesh</option>
               <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
               <option value="Arunachal Pradesh">Arunachal Pradesh</option>
               <option value="Assam">Assam</option>
               <option value="Bihar">Bihar</option>
               <option value="Chandigarh">Chandigarh</option>
               <option value="Chhattisgarh">Chhattisgarh</option>
               <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
               <option value="Daman and Diu">Daman and Diu</option>
               <option value="Delhi">Delhi</option>
               <option value="Lakshadweep">Lakshadweep</option>
               <option value="Puducherry">Puducherry</option>
               <option value="Goa">Goa</option>
               <option value="Gujarat">Gujarat</option>
               <option value="Haryana">Haryana</option>
               <option value="Himachal Pradesh">Himachal Pradesh</option>
               <option value="Jammu and Kashmir">Jammu and Kashmir</option>
               <option value="Jharkhand">Jharkhand</option>
               <option value="Karnataka">Karnataka</option>
               <option value="Kerala">Kerala</option>
               <option value="Madhya Pradesh">Madhya Pradesh</option>
               <option value="Maharashtra">Maharashtra</option>
               <option value="Manipur">Manipur</option>
               <option value="Meghalaya">Meghalaya</option>
               <option value="Mizoram">Mizoram</option>
               <option value="Nagaland">Nagaland</option>
               <option value="Odisha">Odisha</option>
               <option value="Punjab">Punjab</option>
               <option value="Rajasthan">Rajasthan</option>
               <option value="Sikkim">Sikkim</option>
               <option value="Tamil Nadu">Tamil Nadu</option>
               <option value="Telangana">Telangana</option>
               <option value="Tripura">Tripura</option>
               <option value="Uttar Pradesh">Uttar Pradesh</option>
               <option value="Uttarakhand">Uttarakhand</option>
               <option value="West Bengal">West Bengal</option>
				</select>
				 </div>
              <div class="form-group">
               <label><b>GST:</b></label><br>
              <input type="radio"  class="gst" name="gst_select"  value="yes">
				<label for="html">Yes</label><br>
				<input type="text" style="display: none" class="form-control" name="gst" id="gst" placeholder="" />
				<input type="radio" checked="" class="gst" name="gst_select"  value="no">
				<label for="css">No</label><br>
				
            </div>
            <!--<div class="form-group">
               <label>Return URL:</label><br>
               <input class="form-control" name="returnUrl" placeholder="Enter the URL to which customer will be redirected (Ex. www.example.com)"/>
               </div>        
               <div class="form-group">
               <label>Notify URL:</label><br>
               <input class="form-control" name="notifyUrl" placeholder="Enter the URL to get server notificaitons (Ex. www.example.com)"/>
               </div>-->
            <div class="row">
               <div class="col-md-6"><button class="btn btn-primary btn-block" onclick="goBack()">Go Back</button></div>
               <div class="col-md-6"><button type="submit" class="btn btn-primary btn-block" value="Pay">Submit</button></div>
            </div>
            <br> 
            <br>
         </form>
      </div>
      <div class="col-md-3" style="padding-bottom: 52px;"></div>
   </div>
</div>
<div class="row">
   <div class="col-md-6"></div>
   <div class="col-md-6"></div>
</div>
<div class="row">
   <div class="col-md-6"></div>
   <div class="col-md-6"></div>
</div>
<div class="row">
   <div class="col-md-6"></div>
   <div class="col-md-6"></div>
</div>
<br/><br/>

<script>

window.onload = function() {
  //alert("asdf");
  
  var d = new Date();
  var n = d.getTime();
 // var mk= trim(Math.random());
  var mk = Math.floor(1000 + Math.random() * 9000);
  document.getElementById("orderId").value = "OrderID_"+n+mk;
  
//  alert("asdf");   
  
};

// .orderId{
//     alert("asdf");    
        
//     }
   
function goBack() {
  window.history.back();


}
$(".gst").click(function(){
	var value = $(this).val();
	if (value== 'yes') {
	$('#gst').show();	
	}else{
			$('#gst').hide();	
	}
	
});
</script>
@endsection