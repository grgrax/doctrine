
<div class="panel panel-default table-responsive">
	<div class="panel-heading">
		<h4>Donations <span class="badge bg-info"><?=$total?></span></h4>
	</div>  	
	<div class="panel-body">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>S.no</th>
					<th>Donor</th>
					<th>Email</th>
					<th>Amount</th>
					<th>Campaign</th>
					<th>Category</th>
					<th>Comment</th>
					<th width="20%">Time</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$c=$offset;
				$amount=0;
				if(count($donations)>0) { 
					foreach ($donations as $donation) { 
						$c++;
						$amount+=$donation['amount'];
						?>
						<tr>
							<td><?=$c?></td>
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
							<td>
								<?php 
								$campaign=get_campaigns(array('id'=>$donation['campaign_id'])); 
								echo $campaign[0]['campaign_title'];
								?>
							</td>
							<td>
								<?php 
								$fund_category=get_fund_categories(array('id'=>$campaign[0]['fund_category_id'])); 
								echo $fund_category[0]['name'];
								?>
							</td>
							<td><i><?=$donation['comment']?></i></td>
							<td><?=format($donation['date'])?></td>
						</tr>		
						<?php 
					} 
					?>
					<?php
				} 
				else { 
					?>
					<tr>
						<td colspan="8" class="td_no_data">no data</td>
					</tr>		
					<?php } ?>
				</tbody>

			</table>    	
			<ul class="pagination">
				<?php if (!empty($pages)) echo $pages; ?>
			</ul>
		</div>
	</div>
	<script>
		$(function(){

			$("#from_date").datepicker({
				dateFormat: 'dd-mm-yy',
				changeMonth: true,
				changeYear: true,
				onClose: function( selectedDate ) {
					$( "#to_date" ).datepicker( "option", "minDate", selectedDate );
				}
			});
			$("#to_date").datepicker({
				dateFormat: 'dd-mm-yy',
				changeMonth: true,
				changeYear: true,
				minDate: $('#from_date').val()
			});


			var amount_option=$("select[name=amount_option]").val();
			show_amount_section(amount_option);

			$("select[name=amount_option]").change(function(){
				show_amount_section($(this).val());
			});

			function show_amount_section(option){
				hide_amount_secton();
				var amount_option="amount_"+option;
				$("."+amount_option).show();
			}

			function hide_amount_secton(){
				$(".amount_1").hide();
				$(".amount_2").hide();
				$(".amount_3").hide();
				$(".amount_4").hide();
			}

		})
	</script>

	<style>
		.panel-body{
			padding-top: 0px !important;
		}
	</style>
