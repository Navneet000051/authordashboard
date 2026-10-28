@extends('layouts.app')

@section('content')
<div class="content-wrapper">

 <section class="breadcrumb-nav pt-5 mt-5 pt-70">
    <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="page-header">
            <h4 class="page-title"> <span class="page-title-icon bg-gradient-primary text-white me-2"><i class="fa fa-home" aria-hidden="true"></i></span> View Detail </h4>
           </div>
        </div>
      </div>
    </div>
  </section>


<section class="mt-3 pt-4">
  <div class="container">
    <div class="row view-detail ">
      <div class="col-md-12">
        <table id="table" class="table table-striped table-bordered" style="width:100%">
           <thead>
            <tr>
                <th>Sr. No</th>
                <th>Book Title</th>
                <th>Channel Name</th>
                <th>Quantity</th>
                <th>Order Date</th>
                <th>Confirmed</th>
            </tr>
        </thead>
        <tbody>
          <?php
            $i=1;
            foreach($sales as $sale){
          ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $sale->BookTitle; ?></td>
                <td class="fw-bold">
                <?php if($sale->Marketplace=="Flipkart"){ ?>
                  <span><img src="<?php echo base_url() ?>authordashboard/assets/img/flipkart.png" class="img-fluid table-icon"> </span> Flipkart
                <?php }elseif ($sale->Marketplace=="GooglePlay") { ?>
                  <span><img src="<?php echo base_url() ?>authordashboard/assets/img/google.png" class="img-fluid table-icon"> GooglePlay
                <?php }elseif ($sale->Marketplace=="KDP") { ?>
                  <span><img src="<?php echo base_url() ?>authordashboard/assets/img/kdp.png" class="img-fluid table-icon"> KDP
                <?php }elseif ($sale->Marketplace=="Amazon") { ?>
                  <span><img src="<?php echo base_url() ?>authordashboard/assets/img/amazon.png" class="img-fluid table-icon"> Amazon
                <?php }elseif ($sale->Marketplace=="bfc") { ?>
                  <span><img src="<?php echo base_url() ?>authordashboard/assets/img/logo.png" class="img-fluid table-icon"> BFC
                <?php }?>
                </td>
                <td> <?php echo $sale->UnitsSold; ?></td>
                <td><?php echo date("d-M-Y",strtotime($sale->OrderDate)); ?></td>
                <td class="text-success fw-bold"><?php if($sale->OrderItemStatus==''){ echo "Pending"; }else{echo $sale->OrderItemStatus; } ?></td>
            </tr>
          <?php $i++; }?>
        </tbody>
    </table>
      </div>
    </div>
  </div>
</section>

</div>
@endsection

@section('head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
@endsection

@section('scripts')
  <script>
    $(document).ready(function () {
      $('#table').DataTable();
    });
  </script>
@endsection
