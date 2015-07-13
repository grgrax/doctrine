<?php if(count($carts)>0) { ?>
<ul>
	<?php foreach ($carts as $cart) { ?>
	<li>
		<a href="<?php echo base_url('frontend/cart/').'/'.$cart->getId()?>">
			<?php echo $cart->getCartNumber();?>
		</a>
		with <b><?php echo $cart->getCustomer()->getName()?></b> (Customer)  
	</li>
	<?php } ?>
</ul>
<hr>
<?php echo anchor('frontend/cart_add/', 'Add', 'class="btn btn-success"'); ?>
<?php } ?>