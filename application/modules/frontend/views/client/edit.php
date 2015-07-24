<?php if(count($product)>0) { ?>
<form action="" method="POST" role="form">
	<legend>Edit product</legend>

	<div class="form-group">
		<label for="mentor">Shipping</label>
		<select name="mentor" id="" class="form-control">
			<?php foreach ($shippings as $e): ?>
				<option value="<?php echo $e->getId()?>"
					<?php echo $product->getShipping()->getId()==$e->getId()?'selected':''; ?>>
					<?php 
					echo $product->getShipping()->getName();
					echo " ( {$product->getShipping()->getTime()->format('Y-m-d H:m:s') }) ";
					?>
				</option>
			<?php endforeach ?>
		</select>
	</div>


	<div class="form-group">
		<label for="">label</label>
		<input type="text" class="form-control" id="" placeholder="Input field"
		name="name"
		value="<?php echo set_value('name',$product->getName());?>">
	</div>


	<button type="submit" class="btn btn-success" name="submit">Submit</button>
	<?php echo anchor('frontend', 'Cancel', 'class="btn btn-warning"'); ?>

</form>
<?php } ?>