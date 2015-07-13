<table class="table table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>Donor</th>
			<th>Email</th>
			<th>Amount</th>
			<th>Comment</th>
			<th width="20%">Time</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		if(count($donations)>0) { 
			foreach ($donations as $donation) { 
				?>
				<tr>
					<td><?=$donation['id']?></td>
					<td>
					<?php 
					$this->load->helper('donor/donor');
					$donors=get_donors(array('id'=>$donation['donar_id']));
					$donor=$donors[0];
					echo $donor['name']; 
					?>
					</td>
					<td><?=$donor['email']?></td>
					<td><?=$donation['amount']?></td>
					<td><i><?=$donation['comment']?></i></td>
					<td><?=format($donation['date'])?></td>
				</tr>		
				<?php 
			} 
		} 
		else { 
			?>
			<tr>
				<td colspan="6" class="td_no_data">no data</td>
			</tr>		
			<?php } ?>
		</tbody>
	</table>