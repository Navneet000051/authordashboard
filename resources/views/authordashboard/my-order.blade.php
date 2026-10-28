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
                <th>Order No</th>
                <th>Payment Status </th>
                <th>Date</th>
                <th>Transaction ID</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
          <?php
          $i=1;
          foreach ($transaction as $value): ?>
           <tr>
                <th><?php echo $i; ?></th>
                <th><?php echo $value['orderNo']; ?></th>
                <th><?php echo $value['payment_status']; ?></th>
                <th><?php echo $value['orderDate']; ?></th>
                <th><?php echo $value['transaction_id']; ?></th>
                <th><?php echo $value['amount']; ?></th>
            </tr>
          <?php $i++; endforeach ?>
        </tbody>
    </table>
      </div>
    </div>
  </div>
</section>

</div>
@endsection

@section('scripts')
  <script>
    $(document).ready(function () {
      $('#table').DataTable();
    });
  </script>
@endsection
