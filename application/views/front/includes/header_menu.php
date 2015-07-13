
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Best Institute in Rapti</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="<?php echo front_template_path()?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo front_template_path()?>css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="<?php echo front_template_path()?>css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo front_template_path()?>css/main.css">
    <link rel="stylesheet" href="<?php echo front_template_path()?>css/sl-slide.css">
    <link rel="stylesheet" href="<?php echo front_template_path()?>css/custom.css">

    <script src="<?php echo front_template_path()?>./js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="<?php echo front_template_path()?>images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo front_template_path()?>images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo front_template_path()?>images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo front_template_path()?>images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head>

<body>

    <!--Header-->
    <header class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a id="logo" class="pull-left" href="index.html" title="Best Institute in Rapti"></a>
                
                <div class="nav-collapse collapse pull-right" id="menu">
                    <!-- contact info     -->
                    <div class="row">
                        <div class="span8 pull-right">
                            <ul class="unstyled address" id="top_bar">
                                <li>
                                    <i class="icon-phone"></i>
                                    <strong>Cell:</strong> 9801329699
                                </li>
                                <li>
                                    <i class="icon-envelope"></i>
                                    <strong>Email: </strong> info@iitinfotrain.com
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- contact info -->                    
                    <!-- menu -->
                    <?php 
                    $data_menu=get_menus(); 
                    // show_pre($data_menu);
                    echo get_ol($data_menu);
                    ?>
                    <!-- menu -->

                </div><!--/.nav-collapse -->
            </div>
        </div>
    </header>
    <!-- /header -->

    <?php 
    no_of_child_menus(1);
    function get_ol($array, $child = FALSE,$level=0)
    {
        $str = '';   
        if (count($array)) {
            $str .= $child == TRUE ? PHP_EOL.'<ul class="dropdown-menu">': PHP_EOL. '<ul class="nav">' ;
            foreach ($array as $item) {
                $childs=no_of_child_menus($item['id']);
                $class=$childs>1?' dropdown-submenu':'';
                if($item['parent_id']){
                    $str .= (isset($item['children']) && count($item['children'])) ? PHP_EOL.'<li>':PHP_EOL.'<li>';                    
                }
                else{
                    $str .= (isset($item['children']) && count($item['children'])) ? PHP_EOL.'<li class="dropdown'.$class.'">':PHP_EOL.'<li>';
                }
                $attributes= (isset($item['children']) && count($item['children'])) ?' class="dropdown-toggle" data-toggle="dropdown"':'';
                if(isset($item['children']) && count($item['children'])){
                    if($childs>1){
                        if($item['parent_id']){
                            $str .='<a href="'.$item['slug'].'">'.$item['name'].'</a></li>';
                        }else{
                            $str .='<a href="'.$item['slug'].'" data-toggle="dropdown">'.$item['name'].'</a>';
                        }    
                    }else{
                        $str .='<a href="'.$item['slug'].'" '.$attributes.'>'.$item['name'].' <i class="icon-angle-down"></i></a>';                        
                    }
                } 
                else{
                    $str .='<a href="'.$item['slug'].'"'.$attributes.'>'.$item['name'].'</a>';               
                }
            // Do we have any children?
                if (isset($item['children']) && count($item['children'])) {
                    $str .= get_ol($item['children'], TRUE);
                }
                $str .= '</li>' . PHP_EOL;
            }
            $str .= '</ul>' . PHP_EOL;
        }
        return $str;
    }
    ?>