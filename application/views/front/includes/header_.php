
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Crowd</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?php echo front_template_path()?>css/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="<?php echo front_template_path()?>css/bootstrap/bootstrap-responsive.min.css">
    <!-- Bootstrap core CSS -->

    <!-- Custom styles for this template -->
    <link href="<?php echo front_template_path()?>css/style.css" rel="stylesheet">
    <link href="<?php echo front_template_path()?>css/multiformstyle.css" rel="stylesheet">
    <link href="<?php echo front_template_path()?>css/font-awesome.min.css" rel="stylesheet">
    <!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">-->

    <link href="<?php echo front_template_path()?>css/custom.css" rel="stylesheet">
    <script src="<?php echo front_template_path()?>js/jquery.js"></script>
    
    <?php if($this->config->item('enabe_jq_validation')) {?>
    <!-- jquery validation -->
    <link rel="stylesheet" href="<?php echo front_assets_path()?>/jquery-validation-1.13.1/demo/css/screen.css">
    <script src="<?php echo front_assets_path()?>jquery-validation-1.13.1/dist/jquery.validate.js"></script>
    <!-- jquery validation   -->
    <?php } ?>


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="bootstrap/js/html5shiv.js"></script>
<script src="bootstrap/js/respond.min.js"></script>
<![endif]-->

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
                        <span class="btn btn-info btn-social btn-large col-5" 
                        style="margin-top: 10px;padding:7px 10px;color:#fff"
                        data-toggle="modal" data-target="#myModalSignin">
                        <i class="fa fa-sign-in" ></i> <span style="margin-left:35px; font-size:18px;">Log in</span>
                    </span>
                </li>
                <li style="margin-right:20px"> 
                    <span class="btn btn-success btn-social btn-large col-5"  style="margin-top: 10px;padding:7px 10px;color:#fff"
                    data-toggle="modal" data-target="#myModalSignup">
                    <i class="fa fa-check"></i> 
                    <span style="margin-left:35px; font-size:18px;" id="singup">Sign up</span>
                </span>


            </ul>
        </div>
        <?php } ?>
        <!--/.navbar-collapse -->
    </div>
</header>
<div style="height:50px">&nbsp;</div>


<?php 
// echo count(uri_string());
// exit("eh");
// $uris=explode('/', uri_string());
// echo count($uris);
if(uri_string()=='')  {
    ?>



    <div class="jumbotron" id="home">
        <div class="container">
            <div class="media">
                <div class="media-body">
                    <div class="col-md-12">
                        <h1 class="title">Crowd <span>Funding<a href="#"><!--<img class="media-object img-responsive" src="assets/images/Finder_256.png" />--></a></span></h1>

                        <p>DISCOVER YOUR CAMPINGSIGN UP </p>
                        <div class="row col-centered" style="max-width:600px">
                            <a class="btn btn-social btn-facebook col-5">
                                <i class="fa fa-facebook"></i> Sign in with Facebook
                            </a>
                            <span style="color:#111; margin:0 20px;font-size:20px;">OR</span>                           
                            <a class="btn btn-success btn-social btn-large col-5" href="" >
                             <i class="fa fa-check" ></i> Sign up for free
                         </a>
                     </div>

                     <div id="custom-search-input" style="margin-top:70px">
                        <div id="custom-search-input">
                            <div class="input-group col-md-12">
                                <input type="text" class="form-control input-lg" placeholder="SEARCH BY POSTCODE OR NAME" />
                                <span class="input-group-btn">
                                    <button class="btn btn-info btn-lg" type="button">
                                        <i class="fa fa-search" ></i>
                                    </button>
                                </span>
                            </div>                          
                            <i class="fa fa-check" ></i> Sign up for free
                        </a>
                    </div>

                    
                    <!-- <p><a class="btn btn-success btn-lg">Learn more <i class="icon icon-angle-right"></i></a></p>-->
                </div>
            </div>
        </div>
    </div>
</div><!-- end of banner-->

<?php
}

?>




<!-- Modal -->
<div class="modal fade" id="myModalSignup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content center">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h1 class="modal-title" id="myModalLabel">Sign up with</h1>

            </div>
            <div class="modal-body">
                <div class="form-group center-block">
                    <?php 
                    $fb_key=$this->config->item('fb_key');
                    if($fb_key){ ?>
                    <a href="<?php echo base_url("signup/fb/$fb_key")?>" class="btn btn-lg btn-social btn-facebook "><i class="fa fa-facebook"></i>Facebook Account</a>
                    <h1>Or</h1> 
                    <?php } ?>
                    <a href="<?php echo base_url('signup')?>" class="btn btn-lg btn-info">Email Address</a>
                </div>                      
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalSignin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title" id="myModalLabel">Sign in with</h2>
            </div>

            <form action="" method="POST" role="form" class="form_signin" id="form_signin" novalidate>
                <div class="modal-body">
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
                    <div class="form-group center">
                        <?php 
                        if($fb_key){ ?>
                        <a href="<?php echo base_url("donee/auth/fb_login/$fb_key")?>" class="btn btn-lg btn-social btn-facebook "><i class="fa fa-facebook"></i>Facebook Account</a>
                        <h1>or</h1>
                        <?php } ?>
                        <a href="<?php echo base_url("donee")?>" class="btn btn-lg">Email Address</a>
                    </div>
                    <hr>

                    <div class="form-group">
                        <label for="">Email (or username):</label>
                        <input required type="text" class="form-control" id="username" name="username" 
                        tabindex="1" autocorrect="off" spellcheck="false" autocapitalize="off" autofocus="autofocus"
                        value="<?php echo set_value('username');?>" placeholder="e.g., astha@gmail.com">
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input required type="password" class="form-control" id="password" name="password" 
                        tabindex="2" autocorrect="off" spellcheck="false" autocapitalize="off" autofocus="autofocus"
                        value="<?php echo set_value('username');?>" placeholder="e.g., 12456">
                    </div>

                    <div class="form-group">
                        <label for="">Forgot your password? <a href="#">Reset it.</a></label><br>
                        <label>Dont have an account? <a href="<?php echo base_url('signup')?>">Create a account.</a></label>
                        <hr>
                        <input type="submit" class="btn btn-success" name="submit" value="Login">  
                        <a href="#" class="btn btn-default" data-dismiss="modal">Cancel</a>
                    </div>                
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->

