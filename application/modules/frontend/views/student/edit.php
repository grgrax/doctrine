<?php if(count($student)>0) { ?>
<form action="" method="POST" role="form">
	<legend>Edit Student</legend>

	<div class="form-group">
		<label for="mentor">Mentor</label>
		<select name="mentor" id="" class="form-control">
			<option value="null">select</option>
			<?php foreach ($students as $std): ?>
				
				<?php 
				if($std->getId() === $student->getId()) 
					continue;
				if($std->getMentor() &&  $std->getMentor()->getId()===$student->getId()) 
					continue;
				?>
				
				<option value="<?php echo $std->getId()?>"
					<?php 
					if($student->getMentor())
						echo $student->getMentor()->getId()==$std->getId()?'selected':''; 
					?>
					>
					<?php echo $std->getName();?>
				</option>
			<?php endforeach ?>
		</select>
	</div>


	<div class="form-group">
		<label for="">label</label>
		<input type="text" class="form-control" id="" placeholder="Input field"
		name="name"
		value="<?php echo set_value('name',$student->getName());?>">
	</div>


	<button type="submit" class="btn btn-success" name="submit">Submit</button>
	<?php echo anchor('frontend', 'Cancel', 'class="btn btn-warning"'); ?>

</form>
<?php } ?>