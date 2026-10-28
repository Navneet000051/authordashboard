<?php include 'layout/header.php' ?>



<div class="content-wrapper">

 <section class="breadcrumb-nav breadcrumb-bg mt-5 pt-70">
    <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="page-header">
            <h4 class="page-title"> <span class="page-title-icon bg-gradient-primary text-white me-2"><i class="fa fa-home" aria-hidden="true"></i></span> View Sales Ledger </h4>
          </div>
        </div>
      </div>
    </div>
  </section>

<section class="mt-4">
  <div class="container">
    <div class="row justify-content-center cust-shadow">
      <div class="col-md-8">
        <div class="sales-ledger-heading d-flex justify-content-between">
          <div class="title"><h3>Earning's Due</h3></div>
          <div class="calender">
            <form>
             <div class="form-group">
              <label for="calendar"></label>
              <input type="month" name="start"  value="<?php echo date("Y-m");?>" class="form-control" id="calendar" onchange="getprofitDeatils();">
            </div>
           </form>
           </div>
        </div>
         <div class="sales-ledger-data">
        <div class="data fw-400">
          <div class="d-flex justify-content-between">
            <div>Date</div>
            <div id="date">
              <?php
                $time = strtotime(date("Y/m/d"));
                $final = date("m/Y", strtotime("0 month", $time));
                echo "01/".$final;

              ?>

            </div>
          </div>
      </div>
      <div class="data fw-400">
          <div class="d-flex justify-content-between">
            <div>Opening Balance</div>
            <div>₹ <span id="pre_profit"><?php echo $pre_profit; ?></span></div>
          </div>
      </div>
      <div class="data fw-400">
          <div class="d-flex justify-content-between">
            <div>Total Sales</div>
            <div>₹ <span id="current_profit"><?php echo $current_profit; ?></span></div>
          </div>
      </div>
      <div class="data fw-400">
          <div class="d-flex justify-content-between">
            <div>Total Returns</div>
            <div>₹ <span id="tot_return">0.00</span></div>
          </div>
      </div>
      <div class="data">
          <div class="d-flex justify-content-between">
            <div> Net Earnings</div>
            <div class="f-color" >₹ <span id="net_profit"><?php echo $current_profit+$pre_profit; ?></span></div>
          </div>
      </div>
      <div class="data">
          <div class="d-flex justify-content-between">
            <div>Earnings Paid</div>
            <div class="f-color">₹ <span id="earn_profit"><?php echo $tol_paid[0]->paid; ?></span></div>
          </div>
      </div>
      <div class="data">
          <div class="d-flex justify-content-between">
            <div> Balance</div>
            <div class="f-color">₹ <span id="tot_profit"><?php echo ($current_profit+$pre_profit)-$tol_paid[0]->paid; ?></span></div>
          </div>
      </div>

    </div>
  </div>
  </div>
</section>

</div>


<?php include 'layout/footer.php' ?>
<script type="text/javascript">
  function getprofitDeatils(){
    var calendar = $("#calendar").val();
    // alert(calendar);
     $.ajax({
      url: '/AuthorDashboard/getprofitDeatils',
      type: 'POST',
      data: {
        'calendar': calendar
      },
      success: function(data) {
         // alert(data)
        var tot_pro = (parseFloat(JSON.parse(data).pre_profit) + parseFloat(JSON.parse(data).current_profit))-JSON.parse(data).earn_profit;
        $("#pre_profit").html(JSON.parse(data).pre_profit.toFixed(2));
        $("#current_profit").html(JSON.parse(data).current_profit.toFixed(2));
        $("#tot_return").html("0");
        $("#net_profit").html(tot_pro.toFixed(2));
        $("#earn_profit").html(JSON.parse(data).earn_profit);
        $("#tot_profit").html(tot_pro.toFixed(2));
        $("#date").html(JSON.parse(data).date);

      }
    });
  }

</script>
</body>
</html>