@extends('layouts.app')

@section('content')
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
  <?php $user = session('userid') ?>
<section class="pt-5">
  <div class="container">
    <div class="row">
      <div class="col-md-4 stretch-card grid-margin">
        <div class="dashboard bg-gradient-danger card-img-holder text-white">
          <div class="dashboard-body">
            <img src="<?php echo base_url() ?>authordashboard/assets/img/circle.svg" class="card-img-absolute">
            <span class="float-right"><img src="<?php echo base_url() ?>authordashboard/assets/img/due-date.png" class="img-fluid dashboard-img"></span>
            <h3 class="mb-4">Earnings Due</h3>
            <h4><?php
            $tot_profit = $total_profit['total_profit']-$tol_paid[0]->paid;
            if($tot_profit<=0){ echo "0"; }else{ echo $tot_profit; }
            ?></h4>
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
            <h4><?php if($tol_paid[0]->paid==''){ echo "0"; }else{ echo $tol_paid[0]->paid; } ?> </h4>
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


<div>

<?php
  foreach ($sales as $value) {

    if($value->orderYear==2023){
      if($value->orderMonth==1){
        echo '<input type="hidden" id="jan" value="'.$value->sell.'">';
      }elseif($value->orderMonth==2){
        echo '<input type="hidden" id="Feb" value="'.$value->sell.'">';
      }elseif($value->orderMonth==3){
        echo '<input type="hidden" id="Mar" value="'.$value->sell.'">';
      }elseif($value->orderMonth==4){
        echo '<input type="hidden" id="Apr" value="'.$value->sell.'">';
      }elseif($value->orderMonth==5){
        echo '<input type="hidden" id="May" value="'.$value->sell.'">';
      }elseif($value->orderMonth==6){
        echo '<input type="hidden" id="June" value="'.$value->sell.'">';
      }elseif($value->orderMonth==7){
        echo '<input type="hidden" id="July" value="'.$value->sell.'">';
      }elseif($value->orderMonth==8){
        echo '<input type="hidden" id="Aug" value="'.$value->sell.'">';
      }elseif($value->orderMonth==9){
        echo '<input type="hidden" id="Sep" value="'.$value->sell.'">';
      }elseif($value->orderMonth==10){
        echo '<input type="hidden" id="Oct" value="'.$value->sell.'">';
      }elseif($value->orderMonth==11){
        echo '<input type="hidden" id="Nov" value="'.$value->sell.'">';
      }elseif($value->orderMonth==12){
        echo '<input type="hidden" id="Dec" value="'.$value->sell.'">';
      }
    }

  }
?>

<?php

  $months = [
    'April' => 'apr',
    'May' => 'may',
    'June' => 'jun',
    'July' => 'jul',
    'August' => 'aug',
    'September' => 'sep',
    'October' => 'oct',
    'November' => 'nov',
    'December' => 'dec',
    'January' => 'jan',
    'February' => 'feb',
    'March' => 'mar'
];

$chartData = [];

foreach ($months as $id) {
    $chartData[$id] = 0;
}

foreach ($monthData as $row) {
    if (isset($months[$row->Month])) {
        $chartData[$months[$row->Month]] = $row->Orders;
    }
}

?>

  <input type="hidden" id="Apr" value="<?= $chartData['apr']; ?>">
  <input type="hidden" id="May" value="<?= $chartData['may']; ?>">
  <input type="hidden" id="June" value="<?= $chartData['jun']; ?>">
  <input type="hidden" id="July" value="<?= $chartData['jul']; ?>">
  <input type="hidden" id="Aug" value="<?= $chartData['aug']; ?>">
  <input type="hidden" id="Sep" value="<?= $chartData['sep']; ?>">
  <input type="hidden" id="Oct" value="<?= $chartData['oct']; ?>">
  <input type="hidden" id="Nov" value="<?= $chartData['nov']; ?>">
  <input type="hidden" id="Dec" value="<?= $chartData['dec']; ?>">
  <input type="hidden" id="jan" value="<?= $chartData['jan']; ?>">
  <input type="hidden" id="Feb" value="<?= $chartData['feb']; ?>">
  <input type="hidden" id="Mar" value="<?= $chartData['mar']; ?>">

</div>
@endsection

@section('scripts')
<script>

      var Apr = $("#Apr").val();
      var May = $("#May").val();
      var June = $("#June").val();
      var July = $("#July").val();
      var Aug = $("#Aug").val();
      var Sep = $("#Sep").val();
      var Oct = $("#Oct").val();
      var Nov = $("#Nov").val();
      var Dec = $("#Dec").val();
      var Jan = $("#jan").val();
      var Feb = $("#Feb").val();
      var Mar = $("#Mar").val();

      if(Jan==undefined){ Jan = 0; }
      if(Feb==undefined){ Feb = 0; }
      if(Mar==undefined){ Mar = 0; }
      if(Apr==undefined){ Apr = 0; }
      if(May==undefined){ May = 0; }
      if(June==undefined){ June = 0; }
      if(July==undefined){ July = 0; }
      if(Aug==undefined){ Aug = 0; }
      if(Sep==undefined){ Sep = 0; }
      if(Oct==undefined){ Oct = 0; }
      if(Nov==undefined){ Nov = 0; }
      if(Dec==undefined){ Dec = 0; }

      var xValues = [ "Jan", "Feb", "Mar","Apr", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec"];
      var yValues = [ Jan, Feb, Mar,Apr, May, June, July, Aug, Sep, Oct, Nov, Dec];
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
            text: "Monthly Sales 2026",
            font: { size: 50 }
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
      text: "Total Books Sold ( % )"
    }
  }
});
</script>
@endsection
