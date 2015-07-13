<?php
class fund_category extends Admin_Controller
{
	const MODULE='fund_category/';

	function __construct()
	{
		try {
			parent::__construct();
			if(!permission_permit(['administrator-fund-category'])) redirect_to_dashboard();			
			$this->template_data['fund_category_m']=$this->load->model('fund_category_m');
			
			$this->load->model('campaign/campaign_m');
			$this->load->helper(array('fund_category'));
			
			$this->template_data['actions']=fund_category_m::actions();
			$this->template_data['link']=base_url().self::MODULE;
			$this->template_data['rows']=$this->fund_category_m->read_all($this->fund_category_m->count_rows());
			$this->breadcrumb->append_crumb('List Fund Categories',base_url().self::MODULE.'index');			
		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'Error '.$e->getMessage());
			redirect();
		}
	}

	function index($offset=0)
	{
		try {
			if(!permission_permit(['list-fund-category'])) redirect_to_dashboard();
			$per_page=25;
			$total=$this->fund_category_m->count_rows();
			$this->template_data['rows']=$this->fund_category_m->read_all($per_page,$offset);
			if($total>$per_page){
				$this->load->library('pagination');
				$config['base_url']=base_url().self::MODULE."index";
				$config['total_rows']=$total;
				$config['per_page']=$per_page;
				$config['prev']='Previous';
				$config['next']='Next';
				$this->pagination->initialize($config);
				$this->template_data['pages']=$this->pagination->create_links();
			}
			$this->template_data['total']=$total;
			$this->template_data['offset']=$offset;
			$this->template_data['subview']=self::MODULE.'index';
			$this->load->view('admin/main_layout',$this->template_data);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'Couldnt list fund categories '.$e->getMessage());
			$this->controller_redirect();
		}
	}

	function report()
	{
		try {
			if(!permission_permit(['list-fund-category'])) redirect_to_dashboard();
			$per_page=20;
			// most campaign, most donation, most successful, most amount fixed and raised	

			$total_rows=$this->fund_category_m->count_rows();
			$this->template_data['campaigns']=$this->fund_category_m->read_all($per_page,$offset);
			if($total_rows>$per_page){
				$this->load->library('pagination');
				$config['base_url']=base_url().self::MODULE."index";
				$config['total_rows']=$total_rows;
				$config['per_page']=$per_page;
				$config['prev']='Previous';
				$config['next']='Next';
				$this->pagination->initialize($config);
				$this->template_data['pages']=$this->pagination->create_links();
			}
			$this->template_data['offset']=$offset;
			$this->template_data['subview']=self::MODULE.'index';
			$this->load->view('admin/main_layout',$this->template_data);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'Couldnt list fund categories '.$e->getMessage());
			$this->controller_redirect();
		}
	}

	function filter($offset=0)
	{
		try {
			
			if(!permission_permit(['list-fund-category'])) redirect_to_dashboard();
			$per_page=1;
			$total_rows=$this->fund_category_m->count_rows();
			
			$param = '';
			// $geturi = '';
			$filters = array();
			if($this->input->get()){
				foreach($this->input->get() as $k=>$v){
					if($k != 'per_page' && $v !=''){
						$filters[$k]=$v;
						$param .=  $k.'='.$v.'&'; 						
					} 
				}
				$offset = $this->input->get('per_page');
				$param = substr($param,0,-1);
				// echo "<br/>param";	
				// show_pre($param);				

				// $geturi = '?' . http_build_query($filters, '', '&');
			}
			//$users = $this->doctrine->em->getRepository('models\User')->getUserList($offset,$per_page,$filters);
			//filter ends
			
			$offset=$offset?$offset:0;
			$total_rows=$this->fund_category_m->count_filter_result($offset,$filters);
			$this->template_data['rows']=$this->fund_category_m->read_all_filter($per_page,$offset,$filters);
			if($total_rows>$per_page){
				$this->load->library('pagination');
				$config['base_url']=base_url().self::MODULE."filter?$param";
				$config['total_rows']=$total_rows;
				$config['per_page']=$per_page;
				$config['prev']='Previous';
				$config['next']='Next';
				$config['page_query_string'] = TRUE;
				$this->pagination->initialize($config);
				$this->template_data['pages']=$this->pagination->create_links();
			}
			$this->template_data['offset']=$offset;
			$this->template_data['filters']=$filters;
			$this->template_data['subview']=self::MODULE.'filter';
			$this->load->view('admin/main_layout',$this->template_data);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'Couldnt list fund categories '.$e->getMessage());
			$this->controller_redirect();
		}
	}
	
	function add()
	{
		try {
			if(!permission_permit(array('add-fund-category'))) $this->controller_redirect('Permissioin Denied');
			if($this->input->post())
			{
				$rules=$this->fund_category_m->set_rules();
				if($_FILES['image']['name']==''){
					$glyphicon=array(
						'field'=>'glyphicon',
						'label'=>'Image or Glyphicon class',
						'rules'=>'trim|required|xss_clean'
						);
					array_push($rules,$glyphicon);
				}
				$this->form_validation->set_rules($rules);
				if($this->form_validation->run($this)===TRUE)
				{
					$this->template_data['insert_data']=array(
						'name'=>$this->input->post('name'),
						'slug'=>get_slug($this->input->post('name')),
						'description'=>$this->input->post('description'),
						'image'=>$_FILES['image']['name'],
						'glyphicon'=>$this->input->post('glyphicon'),
						'status'=>fund_category_m::PUBLISHED,
						'created_at'=>date('Y-m-d H:i:s'),
						);
					if($_FILES['image']['name']){
						$path=get_relative_upload_file_path();
						$path.=fund_category_m::file_path;
						upload_picture($path,'image');
					}
					$this->fund_category_m->create_row($this->template_data['insert_data']);
					$this->session->set_flashdata('success', 'Fund category added successfully');
					$this->controller_redirect();				
				}
			}			
			$this->breadcrumb->append_crumb('Add','add');
			$this->template_data['subview']=self::MODULE.'add';
			$this->load->view('admin/main_layout',$this->template_data);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'Couldnt add fund category, '.$e->getMessage());
			$this->controller_redirect();
		}
	}

	function edit($slug=FALSE)
	{
		try {
			
			if(!permission_permit(array('list-fund-category','edit-fund-category'))) $this->controller_redirect('Permissioin Denied');
			if(!$slug) throw new Exception("Error Processing Request", 1);
			$response=$this->get_data(array('slug'=>$slug));
			if(!$response['success']) throw new Exception($response['data'], 1);
			$this->template_data['row']=$response['data'];
			$id=$response['data']['id'];

			if($this->input->post())
			{
				$rules=$this->fund_category_m->set_rules(array('name'));
				$name=$this->input->post('name');
				$name_rule=array(
					'field'=>'name',
					'label'=>'Category Fund Name',
					'rules'=>"trim|required|xss_clean|route|is_fund_category_name_unique[$id]",
					// 'rules'=>"trim|required|xss_clean|is_column_name_unique[$id|fund_category/fund_category_m]",
					);
				array_push($rules,$name_rule);
				$this->form_validation->set_rules($rules);
				if($this->form_validation->run($this)===TRUE)
				{
					$this->template_data['update_data']=array(
						'description'=>$this->input->post('description'),
						'image'=>$_FILES['image']['name'],
						'glyphicon'=>$this->input->post('glyphicon'),
						'updated_at'=>date('Y-m-d H:i:s'),
						);
					// die(show_pre($this->template_data['update_data']));
					if($_FILES['image']['name']){
						$path=get_relative_upload_file_path();
						$path.=fund_category_m::file_path;						
						upload_picture($path,'image');
					}
					if(!is_default($slug)){
						$this->template_data['update_data']['name']=$this->input->post('name');
						$this->template_data['update_data']['slug']=get_slug($this->input->post('name'));
					}
					$this->fund_category_m->update_row($id,$this->template_data['update_data']);
					$this->session->set_flashdata('success', 'category updated successfully');
					$this->controller_redirect();				
				}
			}			
			$this->breadcrumb->append_crumb('Edit','edit');
			$this->template_data['subview']=self::MODULE.'edit';
			$this->load->view('admin/main_layout',$this->template_data);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'Couldnt edit category, '.$e->getMessage());
			redirect(current_url());
		}
	}

	function publish($slug=NULL){
		try{
			if(!permission_permit(array('list-fund-category','activate-fund-category'))) $this->controller_redirect('Permissioin Denied');
			if(!$slug) throw new Exception('Invalid paramter');
			$response=$this->get_data(array('slug'=>$slug));
			if(!$response['success']) throw new Exception($response['data'], 1);
			$this->template_data=array('status'=>fund_category_m::PUBLISHED);
			$this->fund_category_m->update_row($response['data']['id'],$this->template_data);
			$this->session->set_flashdata('success', 'category published successfully');
		}
		catch(Exception $e){
			$this->session->set_flashdata('error', 'category not published '.$e->get_dataMessage());
		}
		$this->controller_redirect();				
	}

	function unpublish($slug=NULL){
		try{
			if(!permission_permit(array('list-fund-category','block-fund-category'))) $this->controller_redirect('Permissioin Denied');
			$response=$this->get_data(array('slug'=>$slug));
			if(!$response['success']) throw new Exception($response['data'], 1);
			$this->template_data=array('status'=>fund_category_m::UNPUBLISHED);
			$this->fund_category_m->update_row($response['data']['id'],$this->template_data);
			$this->session->set_flashdata('success', 'category unpublished successfully');
		}
		catch(Exception $e){
			$this->session->set_flashdata('error', 'category not unpublished '.$e->get_dataMessage());
		}
		$this->controller_redirect();				
	}

	function delete($slug=NULL){
		try{
			if(!permission_permit(array('list-fund-category','delete-fund-category'))) $this->controller_redirect('Permissioin Denied');
			if(!$slug) throw new Exception('Invalid paramter');
			$response=$this->get_data(array('slug'=>$slug));
			if(!$response['success']) throw new Exception($response['data'], 1);
			$this->template_data=array('status'=>fund_category_m::DELETED);
			$this->fund_category_m->update_row($response['data']['id'],$this->template_data);
			$this->session->set_flashdata('success', 'category deleted successfully');
		}
		catch(Exception $e){
			$this->session->set_flashdata('error', 'category not deleted '.$e->getMessage());
		}
		$this->controller_redirect();				
	}

	function controller_redirect($msg=false){
		if($msg) $this->session->set_flashdata('error', $msg);
		$this->template_data['link']=base_url().self::MODULE;
		redirect($this->template_data['link']);				
	}

	function get_data($param){
		$response['success']=false;
		$response['data']='Error Processing Request';
		if(!$param) return $response;
		$row=$this->fund_category_m->read_rows_by($param,1);
		if($row) {
			$response['success']=true;
			$response['data']=$row;
		}
		else{
			$response['data']='data not found';
		}
		return $response;
	}



}
?>