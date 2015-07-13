 <?php 

 $admin_template=get_admin_template(config_item('admin_template'));
 $path="templates/".$admin_template['path'];
 
 require_once($path."/includes/header.php"); 
 
 $CI =& get_instance();
 if($CI->session->flashdata('success')){
 	$class="alert-success";
 	$message=$CI->session->flashdata('success');
 }
 else if($CI->session->flashdata('error')){
 	$class="alert-danger";
 	$message=$CI->session->flashdata('error');
 }
 ?>


 <!--Page content-->
 <!--===================================================-->
 <?php 
 if(config_item('admin_template')=='metis'){
 	$section_start='<div class="outer"><div class="inner">';
 	$section_end='</div></div>';
 }
 elseif(config_item('admin_template')=='nifty'){
 	$section_start='<div id="page-content">';
 	$section_end='</div>';
 }
 echo $section_start;
 template_validation();
 if(isset($class) && isset($message)){ 
 	flash_msg($class,$message);
 }
 $this->load->view($subview);
 echo $section_end;
 ?>
 <!--===================================================-->
 <!--End page content-->
 <?php
 require_once($path."/includes/footer.php"); 
 ?>

