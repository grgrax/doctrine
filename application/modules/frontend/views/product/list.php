<?php if(count($products)>0) { ?>
<ul>
	<?php foreach ($products as $product) { ?>
	<li>
		<a href="<?php echo base_url('frontend/product/').'/'.$product->getId()?>">
			<?php echo $product->getName();?>
		</a>
		with 
		<b>
			<?php 
			echo $product->getShipping()->getName();
			echo " ( {$product->getShipping()->getTime()->format('Y-m-d H:m:s') }) ";
			?>
		</b> shipping 
	</li>
	<?php } ?>
</ul>
<hr>
<?php } else {?>
<p>no data</p>
<?php } ?>
<?php echo anchor('frontend/product_add/', 'Add', 'class="btn btn-success"'); ?>
