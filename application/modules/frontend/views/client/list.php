<?php if(count($clients)>0) { ?>
<ul>
	<?php foreach ($clients as $client) { ?>
	<li>
		<a href="<?php echo base_url('frontend/client/').'/'.$client->getId()?>">
			<?php echo $client->getName();?>
		</a>
		with 
		<b><?php echo $client->getCountry()->getName();?> (Country)</b> 
	</li>
	<?php } ?>
</ul>
<hr>
<?php } else {?>
<p>no data</p>
<?php } ?>
<?php echo anchor('frontend/add_client/', 'Add', 'class="btn btn-success"'); ?>
