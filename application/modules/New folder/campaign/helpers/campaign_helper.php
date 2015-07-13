<?php


function days_ago($date){
	$dt = new DateTime($date);
	$ptime = strtotime($dt->format('Y-m-d'));
	return $daysago = time_elapsed_string($ptime );
}

function days_left($date){
	$dt = new DateTime($date);
	$ptime = strtotime($dt->format('Y-m-d'));
	return $daysleft = time_left_string($ptime );
}

function usd_amout($amount){ ?>
<span class="currency currency-small"><span>$ <?php echo $amount?></span> 
<em>AUD</em>
</span>
<?php }  


function campaign_photos_upload($campaign=null){
	if($_FILES && $_FILES['photos']['name'][0]!=''){

		$response['success']=false;

		$CI =& get_instance();
		$config = array(
			'upload_path'   => 'uploads/files/pics/campaign/',
			'allowed_types' => 'jpg|jpeg|gif|png',
			'overwrite'     => 1,                       
			'max_size'     => '2048',                       
			'file_name'     => strtotime('now').'_'.random_string('alnum', 10),                       
			);

		$CI->load->library('upload', $config);
		foreach ($_FILES['photos']['name'] as $key => $value) {
			$CI->upload->initialize($config);
			if(!$CI->upload->do_my_upload('photos', $key)){
				$response['error']=$CI->upload->display_errors();
			}
			else{
				$my_upload['uploaded'][] = array('upload_data' => $CI->upload->data());
			}
		}
		if($my_upload['uploaded']){
			foreach ($my_upload['uploaded'] as $value) {
				$my_upload['uploaded_files'][]=$value['upload_data']['file_name'];
			}
						//merge two serialzed data
			if($campaign['pic'] or $campaign['pic']=='N;'){
				$old_pics = unserialize($campaign['pic']);
				$pics=array_merge($old_pics,$my_upload['uploaded_files']);							
			}else{
				$pics=$my_upload['uploaded_files'];														
			}						
						// show_pre($pics);
						// die;
			$serialze=serialize($pics);
			$response['success']=true;
			$response['data']=$serialze;
		}
		else
			echo "no";
		//show_pre($response);
		return $response;
	}
}

function campaign_photo_remove($id,$pic=null){
	$response['success']=false;
	try {
		$CI =& get_instance();
		if(!$id || !$pic) throw new Exception("Error Processing Request", 1);
		$data['campaign']=$CI->load->model('campaign/campaign_m')->read_row($id);
		if(!$data['campaign']) throw new Exception("Couldnt load campaign", 1);
		if(file_exists( $file = campaign_m::full_path.$pic) ){
			if(!unlink($file)) 	throw new Exception("Unable to unlink", 1);		
			//save new serialize data
			$un_serialized_data = unserialize($data['campaign']['pic']);
			// show_pre($un_serialized_data);
			foreach($un_serialized_data as $key => $value){
				if ($value == $pic) {
					unset($un_serialized_data[$key]);
				}
			}
			$serialized_data = serialize($un_serialized_data);
			$response['success']=true;
			$response['data']=$serialized_data;
		}
		else
			throw new Exception("No media found", 1);
	} catch (Exception $e) {
		$CI->session->set_flashdata('error', 'Couldnt remove picture '.$e->getMessage());
		$response['error']=$e->getMessage();
	}
	return $response;
}

function get_campaigns($param){
	$ci=& get_instance();
	return $data=$ci->load->model('campaign/campaign_m')->read_rows_by($param); 
}

function get_campaign($param){
	$ci=& get_instance();
	return $data=$ci->load->model('campaign/campaign_m')->read_rows_by($param,1); 
}

function is_campaign_own($donee_id=0,$campaign_id=0){
	try {
		if($donee_id===0 or $campaign_id===0) 
			throw new Exception("Error Processing Request", 1);
		$campaign=get_campaign(array('user_id'=>$donee_id,'id'=>$campaign_id));
		if($campaign['user_id']===$donee_id) return true;
		return false;		
	} catch (Exception $e) {

	}
}


?>
