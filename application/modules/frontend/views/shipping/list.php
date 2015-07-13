<?php if(count($students)>0) { ?>
<ul>
	<?php foreach ($students as $student) { ?>
	<li>
		<a href="<?php echo base_url('frontend/student/').'/'.$student->getId()?>">
			<?php echo $student->getName();?>
		</a>
		with <b><?php echo $student->getMentor()?$student->getMentor()->getName():'no';?></b> mentor 
	</li>
	<?php } ?>
</ul>
<hr>
<?php echo anchor('frontend/student_add/', 'Add', 'class="btn btn-success"'); ?>
<?php } ?>