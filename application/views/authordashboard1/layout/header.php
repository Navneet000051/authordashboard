<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> BFC Author Dashboard</title>
        <!-- Favicon icon -->
    <link rel="shortcut icon" href="<?php echo base_url() ?>authordashboard/assets/img/favicon.ico" type="image/x-icon" >
        <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>authordashboard/assets/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>authordashboard/assets/fonts/font-awesome/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>authordashboard/assets/fonts/flaticon/font/flaticon.css">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <link rel="stylesheet" href="<?php echo base_url() ?>authordashboard/assets/css/style.css">

    </head>
  <body>

<header>  
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="index"><img src="<?php echo base_url() ?>authordashboard/assets/img/bfc-logo.png" alt="" class="img-fluid header-logo"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?php echo base_url();?>AuthorDashboard">Home</a>
        </li>
         <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url();?>AuthorDashboard/payable">View Sales Ledger</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url();?>AuthorDashboard/salesreport">View Sales Report</a>
      </li>
  
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><span><img src="<?php echo base_url() ?>authordashboard/assets/img/icon.png" class="img-fluid navbar-icon pr-2"></span> <?php   $msg = $this->session->userdata('author_login')['userName']; 
            echo $msg;?> </a> 
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="<?php echo base_url() ?>AuthorDashboard/myprofile"><span><img src="<?php echo base_url() ?>authordashboard/assets/img/navbar-icon/profile.png" alt="" class="img-fluid navbar-icon"></span> My Profile</a></li>
            <li><a class="dropdown-item" href="<?php echo base_url() ?>AuthorDashboard/change_password"><span><img src="<?php echo base_url() ?>authordashboard/assets/img/navbar-icon/reset-password.png" alt="" class="img-fluid navbar-icon"></span> Change Password </a></li>
            <li><a class="dropdown-item" href="<?php echo base_url() ?>AuthorDashboard/logout"><sapn><img src="<?php echo base_url() ?>authordashboard/assets/img/navbar-icon/logout.png" alt="" class="img-fluid navbar-icon"></sapn>Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
</header>
<style>
.form-select{
  color:black;
}
</style>