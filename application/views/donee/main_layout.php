<?php require_once("includes/header.php"); ?>

<!-- display error -->
<?php
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
<!-- display error ends -->

<?php 
template_validation();
if(isset($class) && isset($message)){ 
	flash_msg($class,$message);
} 
$this->load->view("$subview");
require_once("includes/footer.php");
?>
