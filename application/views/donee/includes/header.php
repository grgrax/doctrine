<!DOCTYPE html>
<html lang="en">
<head>  
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Donee Dashboard - <?php echo site_name()?></title>
  <meta name="description" content="">
  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="<?php echo template_path('donee/assets/css/bootstrap/bootstrap.css')?>" /> 
  <!-- Calendar Styling  -->
  <link rel="stylesheet" href="<?php echo template_path('donee/assets/css/plugins/calendar/calendar.css')?>" />  
  <!-- Fonts  -->
  <link href='http://fonts.googleapis.com/css?family=Raleway:300,400,500,600,200' rel='stylesheet' type='text/css'>    
  <!-- Base Styling  -->
  <link rel="stylesheet" href="<?php echo template_path('donee/assets/css/app/app.v1.css')?>" />
  <link rel="stylesheet" href="<?php echo template_path('donee/assets/css/custom.css')?>" />

  <!-- JQuery v1.9.1 -->
  <script src="<?php echo template_path('donee/assets/js/jquery/jquery-1.9.1.min.js')?>" type="text/javascript"></script>
  <script src="<?php echo template_path('donee/assets/js/plugins/underscore/underscore-min.js')?>"></script>
  <!-- Bootstrap -->
  <script src="<?php echo template_path('donee/assets/js/bootstrap/bootstrap.min.js')?>"></script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body data-ng-app>

  <!-- Preloader -->
  <div class="loading-container">
    <div class="loading">
      <div class="l1"><div></div></div>
      <div class="l2"><div></div></div>
      <div class="l3"><div></div></div>
      <div class="l4"><div></div></div>
    </div>
  </div>
  <!-- Preloader -->

  <aside class="left-panel">
    <div class="user text-center">
      <a href="<?php echo base_url()?>"><h3 class="user-name"><?php echo site_name()?></h3></a>
    </div>
    <nav class="navigation">
      <ul class="list-unstyled">
        <li class="active"><a href="<?php echo base_url('donee')?>"><i class="fa fa-list"></i><span class="nav-label">Dashboard</span></a></li>
        <li class="has-submenu"><a href="#"><i class="fa fa-th"></i> <i class="fa fa-angle-down"></i><span class="nav-label">My Campaigns</span></a>
          <ul class="list-unstyled">
            <li><a href="<?php echo base_url('donee')?>">List</a></li>
            <li><a href="<?php echo base_url('donee/dashboard/add_campaign')?>">Create New Campaign</a></li>
          </ul>
        </li>
        <li class="has-submenu"><a href="<?php echo base_url('donee/dashboard/bank_details')?>"><i class="fa fa-bank"></i> <span class="nav-label">Bank Details</span></a></li>
        <li class="has-submenu"><a href="<?php echo base_url('donee/dashboard/donations')?>"><i class="fa fa-money"></i> <span class="nav-label">Donations</span></a></li>
        <!-- <li class="has-submenu"><a href="#"><i class="glyphicon glyphicon-comment"></i> <span class="nav-label">Comments</span></a></li> -->
        <?php if(!$facebook_user) { ?>
        <li class="has-submenu"><a href="<?php echo base_url('donee/dashboard/profile')?>"><i class="fa fa-user"></i> <span class="nav-label">Profile</span></a></li>
        <li class="has-submenu"><a href="<?php echo base_url('donee/dashboard/change_password')?>"><i class="fa fa-lock"></i> <span class="nav-label">Change Password</span></a></li>
        <?php } ?>
        <li class="has-submenu"><a href="<?php echo base_url('donee/auth/logout')?>"><i class="fa fa-power-off"></i> <span class="nav-label">Logout</span></a></li>
      </ul>
    </nav>
  </aside>
  <!-- Aside Ends-->



  <section class="content">

    <header class="top-head container-fluid">
      <button type="button" class="navbar-toggle pull-left">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <ul class="nav navbar-nav pull-right">
        <li class="dropdown">
          <a data-toggle="dropdown" class="dropdown-toggle" href="#">
            <?php 
            $ci=& get_instance();
            $user=get_user(array('id'=>$ci->session->userdata('donee_id')));
            echo ucfirst($user['first_name']." ".$user['last_name']);
            ?>
            <span class="caret"></span></a>
            <ul role="menu" class="dropdown-menu">
             <?php if(!$facebook_user) { ?>       
             <li><a href="<?php echo base_url('donee/dashboard/profile')?>">Profile</a></li>
             <li><a href="<?php echo base_url('donee/dashboard/change_password')?>">Change Password</a></li>
             <li class="divider"></li>
             <?php } ?>
             <li><a href="<?php echo base_url('donee/auth/logout')?>">Logout</a></li>
           </ul>
         </li>
       </ul>



     </header>
     <!-- Header Ends -->


     <div class="warper container-fluid">
      <ol class="breadcrumb">
        <?php echo $this->breadcrumb->output();?>
      </ol>


