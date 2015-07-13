<script src="<?php echo base_url('templates/front/js/jquery.js');?>"></script>
<?php 
if(count($donations)>0) { 
	echo "<div><h3>".count($donations)." Donations</h3></div><hr/>";
	foreach ($donations as $donation) { 
		$this->load->helper('donor/donor');
		$donors=get_donors(array('id'=>$donation['donar_id']));
		?>
		<h1>$<?php echo $donation['amount']?$donation['amount']:'not set';?> US</h1>
		<?php 											
		$donors=get_donors(array('id'=>$donation['donar_id']));
		$donor=$donors[0];
		?>
		<p><?php echo $donor['name']?$donor['name']:'anonomous';?></p>
		<?php 
		$date = $donation['date'];
		$dt = new DateTime($date);
		$ptime = strtotime($dt->format('Y-m-d'));
		$donartime = time_elapsed_string($ptime );
		echo $donartime;
		?>
		<p><?php echo $donation['comment']?$donation['comment']:'not set';?></p>
		<p><?php echo $donation['date']?format($donation['date']):'not set';?></p>			
		<hr>
		<?php
	} 
	echo "<ul class='pagination'>";
	if (!empty($pages)) {
		$start=$offset+1;
		$end=$per_page+$offset;
		// echo "</br>".
		echo $start."-".$end." of ".$total;
		echo "<br/><br/><span class='ajax'>";
		echo $pages;
		echo "</span>";
	}
	echo "</ul>";
} 
else { 
	echo "<li><span>No Donation</span></li>";
} 


?>
<script src="<?php echo base_url('templates/assets/js/custom.js');?>"></script>
<script>
	$(function(){
		$('.ajax').find('a').addClass('btn btn-info btn-rounded');	
		// $('.ajax').find('a').hmtl('Next').css('float:right;');	
	})
</script>
<style>
	.btn-info{		
		min-width: 17.5%;
	}

	.btn-rounded {
		border-radius: 14px;
		overflow: hidden;
	}
</style>
