@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
<div class="content-wrapper p-0">

  <section class="breadcrumb-nav pt-5 mt-5 pt-70">
    <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="page-header">
            <h4 class="page-title"> <span class="page-title-icon bg-gradient-primary text-white me-2"><i class="fa fa-home" aria-hidden="true"></i></span> Sales Reports ( % )</h4>
           </div>
        </div>
      </div>
    </div>
  </section>

<section class="sales-report mt-5">
  <div class="container">
    <div class="row shadowc bg-white">
    <div class="col-md-12">
  <form>
  <div class="row justify-content-between">
    <div class="form-group col-md-3">
      <label for="booktitle">Select book</label>
      <select id="booktitle" name="booktitle" class="form-select" onchange="getbookDetails();">
        <option>Select</option>
        <?php if(!empty($book_details)){
          foreach($book_details as $key=>$value){ ?>
          <option value="<?php echo $value->BookTitle;?>"><?php echo $value->BookTitle;?></option>
        <?php }}?>
      </select>
      <input type="hidden" value="<?php echo $book_details[0]->leads_id ?? '';?>" name="lead_id" id="lead_id">
    </div>
    <div class="form-group col-md-3">
        <label for="calendar">Report Period From</label>
        <input type="date" name="start"  value="" class="form-control" id="start">
    </div>

    <div class="form-group col-md-3">
       <label for="calendar">Report Period To</label>
      <input type="date" name="end"  value="" class="form-control" id="end">
    </div>
    <div class="form-group col-md-2 pt-3 mt-3">
      <button type="button" class="custom-btn" onclick="view_details();">View Details</button>
    </div>
  </div>
</form>
</div>
</div>
</div>
</section>

<section class="pt-5 mb-4">
  <div class="container">
    <div class="row">

      <div class="col-md-4 stretch-card grid-margin">
        <div class="dashboard card-tale card-img-holder text-white">
          <div class="sreport-body">
            <span class="float-right"><img src="<?php echo base_url() ?>authordashboard/assets/img/book-2.png" class="img-fluid dashboard-img"></span>
            <h3 class="mb-4">Total Books Sold</h3>
            <h5>Qty. <span id="totalSold">0</span></h5>
          </div>
      </div>
    </div>
  <div class="col-md-4">
      <div class="text-center">
          <img src="<?php echo base_url() ?>authordashboard/assets/img/demo-book.png" class="img-fluid mw-200">
        </div>
      </div>
    <div class="col-md-4 stretch-card grid-margin">
        <div class="dashboard card-light-blue card-img-holder text-white">
          <div class="sreport-body">
            <span class="float-right"><img src="<?php echo base_url() ?>authordashboard/assets/img/profit.png" class="img-fluid dashboard-img"></span>
            <h3 class="mb-4">Author's Profit</h3>
            <h5>&#8377; <span id="total_profit">0</span></h5>
          </div>
      </div>
    </div>
</div>
      </div>
</section>




<section class="">
  <div class="container">
    <div class="row">
      <div class="col-md-5">
        <div class="sales-dash-chart">
         <canvas id="myChart" style="height: 280px;width: 100%;"></canvas>
      </div>
    </div>
      <div class="col-md-7">

    <div class="row">
      <div class="col-md-4 stretch-card grid-mrg">
        <div class="sales-report  card-img-holder text-dark">
          <div class="sales-report-body">
            <img src="<?php echo base_url() ?>authordashboard/assets/img/circle.svg" class="card-img-absolute">
            <span class="float-right"><img src="<?php echo base_url() ?>authordashboard/assets/img/logo.png" class="img-fluid sales-report-img"></span>
            <h3 class="mb-3">BFC Store</h3>
            <h5><span id="bfc">0</span> Books</h5>
          </div>
      </div>
    </div>
    <div class="col-md-4 stretch-card grid-mrg">
        <div class="sales-report  card-img-holder text-dark">
          <div class="sales-report-body">
             <img src="<?php echo base_url() ?>authordashboard/assets/img/circle.svg" class="card-img-absolute">
            <span class="float-right"><img src="<?php echo base_url() ?>authordashboard/assets/img/amazon.png" class="img-fluid sales-report-img"></span>
            <h3 class="mb-3">Amazon</h3>
            <h5><span id="amazoncount">0</span> Books</h5>
          </div>
      </div>
    </div>

    <div class="col-md-4 stretch-card grid-mrg">
        <div class="sales-report  card-img-holder text-dark">
          <div class="sales-report-body">
             <img src="<?php echo base_url() ?>authordashboard/assets/img/circle.svg" class="card-img-absolute">
            <span class="float-right"><img src="<?php echo base_url() ?>authordashboard/assets/img/flipkart.png" class="img-fluid sales-report-img"></span>
            <h3 class="mb-3">FlipKart</h3>
            <h5><span id="flipkart">0</span> Books</h5>
          </div>
      </div>
    </div>
    <div class="col-md-4 stretch-card grid-mrg">
        <div class="sales-report  card-img-holder text-dark">
          <div class="sales-report-body">
             <img src="<?php echo base_url() ?>authordashboard/assets/img/circle.svg" class="card-img-absolute">
            <span class="float-right"><img src="<?php echo base_url() ?>authordashboard/assets/img/kdp.png" class="img-fluid sales-report-img"></span>
            <h3 class="mb-3">KDP</h3>
            <h5><span id="kdp">0</span> Books</h5>
          </div>
      </div>
    </div>
    <div class="col-md-4 stretch-card grid-mrg">
        <div class="sales-report  card-img-holder text-dark">
          <div class="sales-report-body">
             <img src="<?php echo base_url() ?>authordashboard/assets/img/circle.svg" class="card-img-absolute">
            <span class="float-right"><img src="<?php echo base_url() ?>authordashboard/assets/img/google.png" class="img-fluid sales-report-img"></span>
            <h3 class="mb-3">Google Play</h3>
            <h5><span id="gpay">0</span> Books</h5>
          </div>
      </div>
    </div>
    <div class="col-md-4 stretch-card grid-mrg">
        <div class="sales-report  card-img-holder text-dark">
          <div class="sales-report-body">
             <img src="<?php echo base_url() ?>authordashboard/assets/img/circle.svg" class="card-img-absolute">
            <span class="float-right"><img src="<?php echo base_url() ?>authordashboard/assets/img/web.png" class="img-fluid sales-report-img"></span>
            <h3 class="mb-3">Others</h3>
            <h5><span id="other">0</span> Books</h5>
          </div>
      </div>
    </div>
  </div>
</div>
      </div>
      <div class="row mt-5 justify-content-end">
        <div class="col-md-2">
          <div class="sales-report-btn">
            <a href="<?php echo base_url();?>AuthorDashboard/view_details" class="custom-btn">View Detailed Report</a>
          </div>
        </div>
    </div>
</section>

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
</div>
@endsection

@section('scripts')
<script type="text/javascript">

  function view_details(){
    var booktitle = $("#booktitle").val();
    var lead_id = $("#lead_id").val();
    var start = $("#start").val();
    var end = $("#end").val();

    $.ajax({
      url: '/AuthorDashboard/getbookDetailsFilter',
      type: 'POST',
      data: {
        'booktitle': booktitle,
        'lead_id': lead_id,
        'start': start,
        'end': end
      },
      success: function(data) {
        $("#totalSold").html(data.totalSold);
        $("#total_profit").html(data.total_profit.toFixed(2));
        $("#flipkart").html(data.flipkart);
        $("#gpay").html(data.gpay);
        $("#kdp").html(data.kdp);
        $("#amazoncount").html(data.amazoncount);
        $("#bfc").html(data.bfc);

        amazonePer = (data.amazoncount/data.totalSold)*100;
        flipkartPer = (data.flipkart/data.totalSold)*100;
        gpayPer = (data.gpay/data.totalSold)*100;
        kdpPer = (data.kdp/data.totalSold)*100;
        bfcPer = (data.bfc/data.totalSold)*100;
        other = 0

        var xValues = ["Amazon", "Flipkart", "KDP","GooglePlay", "BFC", "Others"];
        var yValues = [amazonePer,flipkartPer,kdpPer,gpayPer,bfcPer,other];
        var barColors = [ "#ff4069", "#ffcd56", "#36a2eb", "#db4437", "#0f9d58", "#ff6d00" ];

        new Chart("myChart", {
          type: "doughnut",
          data: { labels: xValues, datasets: [{ backgroundColor: barColors, data: yValues }] },
          options: { title: { display: true, text: "Sales Report ( % )" } }
        });
      }
    });
  }


  function getbookDetails(){
    var booktitle = $("#booktitle").val();
    var lead_id = $("#lead_id").val();
    $.ajax({
      url: '/AuthorDashboard/getbookDetails',
      type: 'POST',
      data: { 'booktitle': booktitle, 'lead_id': lead_id },
      success: function(data) {

        // console.log(JSON.parse(data))

        $("#totalSold").html(data.totalSold);
        $("#total_profit").html(data.total_profit.toFixed(2));
        $("#flipkart").html(data.flipkart);
        $("#gpay").html(data.gpay);
        $("#kdp").html(data.kdp);
        $("#amazoncount").html(data.amazoncount);
        $("#bfc").html(data.bfc);

        amazonePer = (data.amazoncount/data.totalSold)*100;
        flipkartPer = (data.flipkart/data.totalSold)*100;
        gpayPer = (data.gpay/data.totalSold)*100;
        kdpPer = (data.kdp/data.totalSold)*100;
        bfcPer = (data.bfc/data.totalSold)*100;
        other = 0
        var xValues = ["Amazon", "Flipkart", "KDP","GooglePlay", "BFC", "Others"];
        var yValues = [amazonePer,flipkartPer,kdpPer,gpayPer,bfcPer,other];
        var barColors = [ "#ff4069", "#ffcd56", "#36a2eb", "#db4437", "#0f9d58", "#ff6d00" ];

        new Chart("myChart", {
          type: "doughnut",
          data: { labels: xValues, datasets: [{ backgroundColor: barColors, data: yValues }] },
          options: { title: { display: true, text: "Sales Report ( % )" } }
        });
      }
    });
  }

</script>
  <script>
  var xValues = ["Amazon", "Flipkart", "KDP","GooglePlay", "BFC", "Others"];
        var yValues = [0, 0, 0, 0, 0,0];
        var barColors = [ "#ff4069", "#ffcd56", "#36a2eb", "#db4437", "#0f9d58", "#ff6d00" ];

        new Chart("myChart", {
          type: "doughnut",
          data: { labels: xValues, datasets: [{ backgroundColor: barColors, data: yValues }] },
          options: { title: { display: true, text: "Sales Report ( % )" } }
        });
</script>
@endsection
