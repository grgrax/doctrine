<?php if(count($customers)>0) { ?>
<ul>
	<?php foreach ($customers as $customer) { ?>
	<li>
		<a href="<?php echo base_url('frontend/customer/').'/'.$customer->getId()?>">
			<?php echo $customer->getName();?>
		</a>
		with <b><?php echo $customer->getCart()->getCartNumber()?></b> (cart) 
	</li>
	<?php } ?>
</ul>
<?php } else {?>
	<ul><li>no data</li></ul>
<?php } ?>
<hr>
<?php echo anchor('frontend/customer_add/', 'Add', 'class="btn btn-success"'); ?>
