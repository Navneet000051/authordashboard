<?php include 'layout/header.php' ?>

<div class="content-wrapper mt-5 pt-5">

  <section class="pt-4 breadcrumb-nav">
    <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="page-header">
            <h4 class="page-title"> <span class="page-title-icon bg-gradient-primary text-white me-2"><i class="fa fa-home" aria-hidden="true"></i></span> Dashboard </h4>
           </div>
        </div>
      </div>
    </div>
  </section>
  <?php 
    // print_r($dd);
    // exit;
   $user = $this->session->userdata('userid') ?>
<section class="pt-5">
  <div class="container">
    <div class="row">
      <div class="col-md-4 stretch-card grid-margin">
        <div class="dashboard bg-gradient-danger card-img-holder text-white">
          <div class="dashboard-body">
            <img src="<?php echo base_url() ?>authordashboard/assets/img/circle.svg" class="card-img-absolute">
            <span class="float-right"><img src="<?php echo base_url() ?>authordashboard/assets/img/due-date.png" class="img-fluid dashboard-img"></span>
            <h3 class="mb-4">Earnings Due</h3>
            <h4><?php if($total_profit['total_profit']==''){ echo "0"; }else{ echo $total_profit['total_profit']; } ?></h4>
          </div>
      </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
        <div class="dashboard bg-gradient-info card-img-holder text-white">
          <div class="dashboard-body">
            <img src="<?php echo base_url() ?>authordashboard/assets/img/circle.svg" class="card-img-absolute">
            <span class="float-right"><img src="<?php echo base_url() ?>authordashboard/assets/img/payment.png" class="img-fluid dashboard-img"></span>
            <h3 class="mb-4">Next Payment Date</h3>
            <h4>
              <?php
              $time = strtotime(date("Y/m/d"));
              $final = date("m/Y", strtotime("+1 month", $time));

              if (date('d') >= 20) {
                echo "20" . "/" . $final;
              } elseif (date('d') < 20) {
                echo "20" . "/" . date('m') . "/" . date("Y");
              } else {
                echo "DD MM, YYYY";
              } ?>
            </h4>
          </div>
      </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
        <div class="dashboard bg-gradient-success card-img-holder text-white">
          <div class="dashboard-body">
            <img src="<?php echo base_url() ?>authordashboard/assets/img/circle.svg" class="card-img-absolute">
            <span class="float-right"><img src="<?php echo base_url() ?>authordashboard/assets/img/paid.png" class="img-fluid dashboard-img"></span>
            <h3 class="mb-4">Paid To Author </h3>
            <h4>00</h4>
          </div>
      </div>
    </div>
  </div>
</div>
</section>

<section class="pb-5">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="dash-chart">
         <canvas id="myBarChart"></canvas>
      </div>
    </div>
     
      <div class="col-md-6">
        <div class="dash-chart">
         <canvas id="myChart"></canvas>
      </div>
    </div>
    </div>
  </div>
</section>

<section>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="book-publishe text-center">
          <img src="<?php echo base_url() ?>authordashboard/assets/img/book.png" class="img-fluid mb-4" >
          <a href="<?php echo base_url() ?>AuthorDashboard/book_publish" class="pb-5"><h4>Publish New Book</h4></a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="book-publishe text-center">
          <img src="<?php echo base_url() ?>authordashboard/assets/img/refer.jpg" class="img-fluid mb-4" >
          <a href="<?php echo base_url() ?>AuthorDashboard/refer_friend" class="pb-5"><h4>Refer Your Friends</h4></a>
        </div>
      </div>
    </div>
  </div>
</section>


</div>

<?php include 'layout/footer.php' ?>

<script>
var xValues = ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec"];
var yValues = [25, 32, 40, 24, 50, 42, 22, 35, 44, 38, 28, 34];
var barColors = ["#36a2eb", "#36a2eb","#36a2eb","#36a2eb","#36a2eb", "#36a2eb","#36a2eb", "#36a2eb","#36a2eb","#36a2eb","#36a2eb", "#36a2eb"];

new Chart("myBarChart", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "Monthly Sales",
      font: {
          size: 50
        }
    }
  }
});
</script>




  <script>

        total_profit = <?php if($total_profit['total_profit']==''){ echo "0"; }else{ echo $total_profit['total_profit']; }  ?>;
        totalSold = <?php if($total_profit['totalSold']==''){ echo "0"; }else{ echo $total_profit['totalSold']; }   ?>;
        amazoncount = <?php if($total_profit['amazoncount']==''){ echo "0"; }else{ echo $total_profit['amazoncount']; } ?>;
        flipkart = <?php if($total_profit['flipkart']==''){ echo "0"; }else{ echo $total_profit['flipkart']; }  ?>;
        gpay = <?php if($total_profit['gpay']==''){ echo "0"; }else{ echo $total_profit['gpay']; } ?>;
        kdp = <?php if($total_profit['kdp']==''){ echo "0"; }else{ echo $total_profit['kdp']; } ?>;
        bfc = <?php if($total_profit['bfc']==''){ echo "0"; }else{ echo $total_profit['bfc']; }   ?>;


        amazonePer = (amazoncount/totalSold)*100;
        flipkartPer = (flipkart/totalSold)*100;
        gpayPer = (gpay/totalSold)*100;
        kdpPer = (kdp/totalSold)*100;
        bfcPer = (bfc/totalSold)*100;
        other = 0

        var xValues = ["Amazon", "Flipkart", "KDP","GooglePlay", "BFC", "Others"];
        console.log("total_profit")

        if(total_profit==0){
          var yValues = [0,0,0,0,0,0];
        }else{
          var yValues = [amazonePer.toFixed(0),flipkartPer.toFixed(0),kdpPer.toFixed(0),gpayPer.toFixed(0),bfcPer.toFixed(0),other];
        }

        
        
        var barColors = [
          "#ff4069",
          "#ffcd56",
          "#36a2eb",
          "#db4437",
          "#0f9d58",
          "#ff6d00",
        ];

new Chart("myChart", {
  type: "doughnut",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues,
    }]
  },
  options: {
    title: {
      display: true,
      text: "Total Books Sold"
    }
  }
});
</script>
</body>
</html>