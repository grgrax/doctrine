
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Our Library</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?php echo front_template_path()?>css/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="<?php echo front_template_path()?>css/bootstrap/bootstrap-responsive.min.css">
    <!-- Bootstrap core CSS -->

    <!-- Custom styles for this template -->
    
    <link href="<?php echo front_template_path()?>css/multiformstyle.css" rel="stylesheet">
    <link href="<?php echo front_template_path()?>css/font-awesome.min.css" rel="stylesheet">

    <!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">-->
    <link href="<?php echo front_template_path()?>css/style.css" rel="stylesheet">

    <link href="<?php echo front_template_path()?>css/custom.css" rel="stylesheet">

    <script src="<?php echo front_template_path()?>js/jquery.js"></script>
    
    <?php if($this->config->item('enabe_jq_validation')) {?>
    <!-- jquery validation -->
    <link rel="stylesheet" href="<?php echo front_assets_path()?>/jquery-validation-1.13.1/demo/css/screen.css">
    <script src="<?php echo front_assets_path()?>jquery-validation-1.13.1/dist/jquery.validate.js"></script>
    <!-- jquery validation   -->
    <?php } ?>



</head>

<body class="row-fluid" <?php if($this->uri->segment(1) == 'signup'|| $this->uri->segment(1) == 'campaign') { ?> style="background-color:#aaa" <?php } ?>>
    <!-- Site header and navigation -->
    <header class="navbar navbar-inverse navbar-fixed-top" id="topnav">
        <div class="">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand"  href="<?php echo base_url();?>" ><img src="<?php echo front_template_path()?>/assets/images/expose-logo.png" alt="OurLibrary" /> </a>
            </div>
            <?php if($this->uri->segment(1) !== 'signup') {?>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav pull-right">
                    <li class="active"><a href="#home"><i class="fa fa-exclamation-circle" ></i> How it Works</a></li>
                    <li><a href=""><i class="fa fa-check-circle-o" ></i> Success Stories</a></li>
                    <li><a href=""><i class="fa fa-question-circle" ></i> Help</a></li>

                    <li style="margin-right:20px"> 
                        <a href="<?php echo base_url('donee')?>">

                            <span class="btn btn-info btn-social btn-large col-5" 
                            style="margin-top: -10px;padding:7px 10px;color:#fff"
                            data-toggle="modal" data-target="#myModalSignin">
                            <i class="fa fa-sign-in" ></i> <span style="margin-left:35px; font-size:18px;">Log in</span>
                        </a>
                    </span>
                </li>
                <li style="margin-right:20px"> 
                    <a href="<?php echo base_url('signup')?>">
                        <span class="btn btn-success btn-social btn-large col-5"  style="margin-top: -10px;padding:7px 10px;color:#fff"
                        data-toggle="modal" data-target="#myModalSignup">
                        <i class="fa fa-check"></i> 
                        <span style="margin-left:35px; font-size:18px;" id="singup">
                            Sign up
                        </span>
                    </a>
                </li>


            </ul>
        </div>
        <?php } ?>
        <!--/.navbar-collapse -->
    </div>
</header>
<div style="height:50px">&nbsp;</div>


<div class="jumbotron" id="home">
    <div class="container">
    </div>
</div>

