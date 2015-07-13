
<div class="panel panel-default table-responsive">
	<div class="panel-heading">
		Donations
		<span class="badge badge-info"><?=$total?></span>
	</div>
	<div class="panel-body">
		<form action="" method="GET" role="form">
			<h5 class="text-center">Filter data by</h5><br>
			<table class="table filter">			
				<tbody>
					<tr>
						<td class="col-lg-3">
							<div class="form-group">
								<label>Campaign</label>
								<select id="campaign_id" class="form-control" name="campaign_id">
									<option value="">Select</option>
									<?php foreach (get_campaigns(array('status !='=>campaign_m::DELETED)) as $campaign) { ?>
										<option value="<?=$campaign['id']?>"
											<?php echo $this->input->get('campaign_id')==$campaign['id']?'selected':'';?>
											>
											<?=my_word_limiter($campaign['campaign_title'])?>
										</option>
										<?php } ?>
									</select>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label>Donee</label>
									<select id="user_id" class="form-control" name="user_id">
										<option value="">Select</option>										
										<?php foreach (get_donees(1) as $donee) { ?>
										<option value="<?=$donee['id']?>"
											<?php echo $this->input->get('user_id')==$donee['id']?'selected':'';?>
											>
											<?=$donee['first_name']." ".$donee['last_name']?>
										</option>
										<?php } ?>
									</select>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label>Fund Category</label>
									<select id="fund_category_id" class="form-control" name="fund_category_id">
										<option value="">Select</option>
										<?php foreach (get_fund_categories(array('status '=>campaign_m::ACTIVE)) as $fund_category) { ?>
											<option value="<?=$fund_category['id']?>"
												<?php echo $this->input->get('fund_category_id')==$fund_category['id']?'selected':'';?>
												>
												<?=my_word_limiter($fund_category['name'])?>
											</option>
											<?php } ?>
										</select>
									</div>
								</td>
								<td>
									<div class="form-group">
										<label>Donor</label>
										<select id="donar_id" class="form-control" name="donar_id">
											<option value="">Select</option>
											<?php foreach (get_donors(array('id >'=>'0')) as $donor) { ?>
											<option value="<?=$donor['id']?>"
												<?php echo $this->input->get('donar_id')==$donor['id']?'selected':'';?>
												>
												<?=$donor['name'].'			( '.$donor['email'].' )';?>
											</option>
											<?php } ?>
										</select>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="form-group">
										<label>From Date</label>
										<div class="controls">
											<input type="text" name="from_date" id="from_date"  data-required="1" 
											class="form-control" placeholder="05-06-2015"
											value="<?=$this->input->get('from_date')?$this->input->get('from_date'):''?>">
										</div>
									</div>
								</td>
								<td>
									<div class="form-group">
										<label>To Date</label>
										<div class="controls">
											<input type="text" name="to_date" id="to_date" data-required="1" 
											class="form-control" placehoder="05-10-2015"
											value="<?=$this->input->get('to_date')?$this->input->get('to_date'):''?>">
										</div>
									</div>
								</td>
								<td>
									<?php 
									$amount_option=array(
										'1'=>'Equal to',
										'2'=>'Above',
										'3'=>'Below',
										'4'=>'Between',
										);
										?>
										<div class="form-group center">
											<label>Amount</label>
											<select id="amount_option" class="form-control" name="amount_option">
												<?php foreach ($amount_option as $k=>$v) { ?>
												<option value="<?=$k?>"
													<?php echo $this->input->get('amount_option')==$k?'selected':'';?>
													>
													<?=$v;?>
												</option>
												<?php } ?>
											</select>
										</div>
									</td>
									<td>
										<div class="form-group">
											<span class="amount_1">
												<label>Equal to</label>
												<input type="text" class="form-control" name="amount_equal_to" placeholder="equal to" 
												value="<?=$this->input->get('amount_equal_to')?$this->input->get('amount_equal_to'):''?>">
											</span>
											<span class="amount_2">
												<label>Above </label>
												<input type="text" class="form-control" name="amount_above" placeholder="Above" 
												value="<?=$this->input->get('amount_above')?$this->input->get('amount_above'):''?>">
											</span>
											<span class="amount_3">
												<label>Below </label>										
												<input type="text" class="form-control" name="amount_below" placeholder="Below" 
												value="<?=$this->input->get('amount_below')?$this->input->get('amount_below'):''?>">
											</span>
											<span class="amount_4">
												<label>Start from </label>
												<input type="text" class="form-control" name="amount_start_from" placeholder="Start from" 
												value="<?=$this->input->get('amount_start_from')?$this->input->get('amount_start_from'):''?>">
												<label>End at </label>										
												<input type="text" class="form-control" name="amount_end_at" placeholder="End at" 
												value="<?=$this->input->get('amount_end_at')?$this->input->get('amount_end_at'):''?>">
											</span>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="form-group pull-right">
							<input type="submit" class="btn btn-info" name="filter" value="Filter">
							<a href="<?=$link?>" class="btn btn-info">Reset</a>
						</div>
					</form>
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
										<td><?php echo $c?></td>
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
