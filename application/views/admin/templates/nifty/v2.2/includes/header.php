<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - <?php echo site_name()?></title>


  <!--STYLESHEET-->
  <!--=================================================-->

  <!--Open Sans Font [ OPTIONAL ] -->
  <!--Bootstrap Stylesheet [ REQUIRED ]-->
  <link href="<?=admin_template_asset_path()?>/css/bootstrap.min.css" rel="stylesheet">
  

  <!-- bs3 assets for tinymice-->
  <link href="<?=base_url()?>/templates/assets/bootstrap/v3/core/css/bootstrap.min.css" rel="stylesheet">
  <!-- <link rel="stylesheet" type="text/css" href="<?=base_url()?>/templates/assets/bootstrap/v3/core/css/bootstrap-theme.min.css"></link> -->
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>/templates/assets/bootstrap/v3/components/wysiwyg/bootstrap3-wysihtml5.min.css"></link>
  <!-- bs3 assets -->

  <?php if($this->config->item('enabe_jq_validation_backend')) {?>
  <!-- jquery validation -->
  <link rel="stylesheet" href="<?=base_url()?>templates/assets/jquery-validation-1.13.1/demo/css/screen.css">
  <!-- jquery validation   -->
  <?php } ?>


  
  <!--Nifty Stylesheet [ REQUIRED ]-->
  <link href="<?=admin_template_asset_path()?>/css/nifty.min.css" rel="stylesheet">
  <!--Font Awesome [ OPTIONAL ]-->
  <link href="<?=admin_template_asset_path()?>/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!--Animate.css [ OPTIONAL ]-->
  <link href="<?=admin_template_asset_path()?>/plugins/animate-css/animate.min.css" rel="stylesheet">
  <!--Morris.js [ OPTIONAL ]-->
  <link href="<?=admin_template_asset_path()?>/plugins/morris-js/morris.min.css" rel="stylesheet">
  <!--Switchery [ OPTIONAL ]-->
  <link href="<?=admin_template_asset_path()?>/plugins/switchery/switchery.min.css" rel="stylesheet">
  <!--Bootstrap Select [ OPTIONAL ]-->
  <link href="<?=admin_template_asset_path()?>/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
  <!--Demo script [ DEMONSTRATION ]-->
  <link href="<?=admin_template_asset_path()?>/css/demo/nifty-demo.min.css" rel="stylesheet">
  <!--custom-->
  <link href="<?=admin_template_asset_path()?>/css/custom.css" rel="stylesheet">

  <!--SCRIPT-->
  <!--=================================================-->
  <!--Page Load Progress Bar [ OPTIONAL ]-->
  <link href="<?=admin_template_asset_path()?>/plugins/pace/pace.min.css" rel="stylesheet">
  <script src="<?=admin_template_asset_path()?>/plugins/pace/pace.min.js"></script>

  <!--jQuery [ REQUIRED ]-->
  <script src="<?=base_url()?>templates/assets/jquery/2.x/jquery-2.1.1.min.js"></script>
  
  <?php if($this->config->item('enabe_jq_validation_backend')) {?>
  <!-- jquery validation -->
  <script src="<?=base_url()?>templates/assets/jquery-validation-1.13.1/dist/jquery.validate.js"></script>
  <!-- jquery validation   -->
  <?php } ?>

  <!-- datepicker -->
  <link rel="stylesheet" href="<?=base_url()?>templates/assets/jquery/ui/datepicker_1.11.4/themes/smoothness/jquery-ui.css">
  <script src="<?=base_url()?>templates/assets/jquery/ui/datepicker_1.11.4/jquery-ui.js"></script>
  <!-- datepicker -->


</head>
<body>



  <div id="container" class="effect mainnav-lg">

    <!--NAVBAR-->
    <!--===================================================-->
    <header id="navbar">
      <div id="navbar-container" class="boxed">

        <!--Brand logo & name-->
        <!--================================-->
        <div class="navbar-header">
          <a href="<?=base_url()?>" class="navbar-brand">
            <div class="brand-title">
              <span class="brand-text"><?=config_item('site_name')?></span>
            </div>
          </a>
        </div>
        <!--================================-->
        <!--End brand logo & name-->


        <!--Navbar Dropdown-->
        <!--================================-->
        <div class="navbar-content clearfix">
          <ul class="nav navbar-top-links pull-left">

            <!--Navigation toogle button-->
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
            <li class="tgl-menu-btn">
              <a class="mainnav-toggle" href="#">
                <i class="fa fa-navicon fa-lg"></i>
              </a>
            </li>
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
            <!--End Navigation toogle button-->


          </ul>
          <ul class="nav navbar-top-links pull-right">


            <!--User dropdown-->
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
            <li id="dropdown-user" class="dropdown">
              <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
                <span class="pull-right">
                  <img class="img-circle img-user media-object" src="<?=admin_template_asset_path()?>/img/av1.png" alt="Profile Picture">
                </span>
                <div class="username hidden-xs">
                  <?php 
                  $ci=& get_instance();
                  $user=get_user(array('id'=>$ci->session->userdata('id')));
                  echo $user['first_name']." ".$user['last_name'];
                  ?>
                </div>
              </a>


              <div class="dropdown-menu dropdown-menu-md dropdown-menu-right with-arrow panel-default">

                <!-- Dropdown heading  -->
                <div class="pad-all bord-btm">
                  <p class="text-lg text-muted text-thin mar-btm">100mb of 1Gb Used</p>
                  <div class="progress progress-sm">
                    <div class="progress-bar" style="width: 10%;">
                      <span class="sr-only">10%</span>
                    </div>
                  </div>
                </div>


                <!-- User dropdown menu -->
                <ul class="head-list">
                  <li>
                    <a href="<?=base_url('user/profile')?>">
                      <i class="fa fa-user fa-fw fa-lg"></i> Profile
                    </a>
                  </li>
                  <!-- <li>
                    <a href="#">
                      <span class="badge badge-danger pull-right">9</span>
                      <i class="fa fa-envelope fa-fw fa-lg"></i> Messages
                    </a>
                  </li> -->
                  <li>
                    <a href="<?php echo base_url('setting');?>">
                      <i class="fa fa-gear fa-fw fa-lg"></i> Settings
                    </a>
                  </li>
                </ul>

                <!-- Dropdown footer -->
                <div class="pad-all text-right">
                  <a href="<?=base_url('auth/logout')?>" class="btn btn-primary">
                    <i class="fa fa-sign-out fa-fw"></i> Logout
                  </a>
                </div>
              </div>
            </li>
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
            <!--End user dropdown-->

          </ul>
        </div>
        <!--================================-->
        <!--End Navbar Dropdown-->

      </div>
    </header>
    <!--===================================================-->
    <!--END NAVBAR-->

    <div class="boxed">

      <!--CONTENT CONTAINER-->
      <!--===================================================-->
      <div id="content-container">

        <!--Page Title-->
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <div id="page-title">
          <h1 class="page-header text-overflow">Dashboard</h1>

          <!--Searchbox-->
         <!--  <div class="searchbox">
            <div class="input-group custom-search-form">
              <input type="text" class="form-control" placeholder="Search..">
              <span class="input-group-btn">
                <button class="text-muted" type="button"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div> -->

        </div>
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <!--End page title-->


        <!--Breadcrumb-->
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

        <ol class="breadcrumb">
          <?php echo $this->breadcrumb->output();?>
        </ol>
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <!--End breadcrumb-->







