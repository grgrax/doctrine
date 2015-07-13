<!DOCTYPE html>
<html class="login-bg">
<head>
  <title><?php echo site_name()?> - Donee Log in</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- bootstrap -->
  <link href="<?php echo base_url()?>templates/donee/login/bootstrap.css" rel="stylesheet" />
  <link href="<?php echo base_url()?>templates/donee/login/bootstrap-overrides.css" type="text/css" rel="stylesheet" />
  <!-- global styles -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>templates/donee/login/layout.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>templates/donee/login/elements.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>templates/donee/login/icons.css" />
  <!-- libraries -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>templates/donee/login/font-awesome.css" />
  <!-- this page specific styles -->
  <link rel="stylesheet" href="<?php echo base_url()?>templates/donee/login/signin.css" type="text/css" media="screen" />
  <!-- open sans font -->
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css' />
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<body>
  <div class="login-wrapper">    
    <a href="<?php echo base_url()?>">
      <h2><?php echo site_name()?></h2>
      <br>
      <br>
      <br>
      <!-- <img class="logo" src="../../templates/donee/login/img/logo.jpg" alt="logo" /> -->
    </a>
    <div class="box">
      <div class="content-wrap">
        <h6>Log in</h6>
        <form action="" method="POST" role="form" id="form" novalidate> 
          <?php if($this->session->flashdata('error') or validation_errors()){ ?>
          <!-- flash message -->
          <div class="form-group">     
            <div class="alert alert-danger" alert-dismissible>
              <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
              </button>
              <?php echo $this->session->flashdata('error')?$this->session->flashdata('error'):'';?>
              <?php if(validation_errors()) echo validation_errors()?>
            </div>
          </div>
          <!-- flash message ends-->
          <?php } ?>                 
          <input required type="text" class="form-control" id="username" name="username" 
          tabindex="1" autocorrect="off" spellcheck="false" autocapitalize="off" autofocus="autofocus"
          value="<?php echo set_value('username');?>" placeholder="username">
          <input required type="password" class="form-control" id="password" name="password" 
          tabindex="2" autocorrect="off" spellcheck="false" autocapitalize="off" autofocus="autofocus"
          value="<?php echo set_value('username');?>" placeholder="password">
          <a href="#" class="forgot">Forgot password?</a>
          <div class="remember">
            <input id="remember-me" type="checkbox">
            <label for="remember-me">Remember me</label>
          </div>
          <input type="submit" class="btn-glow primary login" name="submit" value="Log in">  
        </form>
      </div>
    </div>
  </body>
  </html>
  <script src="<?php echo base_url('templates/donee/login/jquery-latest.js')?>"></script>
  <script src="<?php echo base_url('templates/donee/login/bootstrap.min.js')?>"></script>
  <style>
    .alert-danger {
      background-color: #f76c51;
      border-color: #f76c51;
      color: white;
    }
    .login-wrapper a{
      text-decoration: none;
      /*text-transform: uppercase;*/
    }
    .login-wrapper h2{
      opacity: 0.6;
    }
    .login-wrapper h2:hover{
      opacity: 1;
    }
  </style>