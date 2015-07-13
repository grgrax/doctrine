<?php 
class filemanager extends Admin_Controller
{
	const MODULE='filemanager/';

	function __construct()
	{
		parent::__construct();
		//if(!permission_permit(['administrator-filemanager'])) redirect_to_dashboard();
		$this->template_data['link']=base_url().self::MODULE;
		$this->template_data['url']=base_url().self::MODULE;
		$this->breadcrumb->append_crumb('File manager',base_url().self::MODULE.'index');
	}

	function index($offset=0)
	{
		//if(!permission_permit(['list-filemanager'])) redirect_to_dashboard();
		$this->template_data['subview']=self::MODULE.'list';
		$this->load->view('admin/main_layout',$this->template_data);
	}

	function add()
	{
		try {
			if(!permission_permit(array('list-filemanager','add-filemanager'))) $this->controller_redirect('Permissioin Denied');
			if($this->input->post())
			{
				$this->form_validation->set_rules($this->filemanager_m->set_rules(array('status')));
				if($this->form_validation->run($this)===TRUE)
				{
					$this->template_data['insert_data']=array(
						'name'=>$this->input->post('name'),
						'slug'=>get_slug($this->input->post('name')),
						'desc'=>$this->input->post('desc'),
						'status'=>0,
						'order'=>$this->filemanager_m->count_rows()+1,
						);
					if($this->input->post('parent_filemanager')){
						$this->template_data['insert_data']['parent_id']=$this->input->post('parent_filemanager');
					}
					if($this->input->post('page_type')>=0)
						$this->template_data['insert_data']['page_type_id']=$this->input->post('page_type');
					$this->filemanager_m->create_row($this->template_data['insert_data']);
					$this->session->set_flashdata('success', 'filemanager added successfully');
					$this->controller_redirect();				
				}
			}			
			$this->breadcrumb->append_crumb('Add','add');
			$this->template_data['rows']=$this->filemanager_m->read_all();
			$this->template_data['subview']=self::MODULE.'add';
			$this->load->view('admin/main_layout',$this->template_data);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'Couldnt add filemanager '.$e->getMessage());
			$this->controller_redirect();
		}
	}

	function edit($slug=FALSE)
	{
		try {
			if(!permission_permit(array('list-filemanager','edit-filemanager'))) throw new Exception("Permissioin Denied", 1);
			if(!$slug) throw new Exception("Error Processing Request", 1);
			$response=$this->get($slug);
			if(!$response['success']) throw new Exception($response['data'], 1);
			$this->template_data['row']=$response['data'];
			
			if($this->input->post())
			{
				$this->form_validation->set_rules($this->filemanager_m->set_rules());
				if($this->form_validation->run($this)===TRUE)
				{
					$this->template_data['update_data']=array(
						'name'=>$this->input->post('name'),
						'desc'=>$this->input->post('desc'),
						'status'=>$this->input->post('status'),
						);
					$parent=$this->input->post('parent_filemanager')?$this->input->post('parent_filemanager'):NULL;
					$this->template_data['update_data']['parent_id']=$parent;
					
					if($this->input->post('page_type')>=0)
						$this->template_data['update_data']['page_type_id']=$this->input->post('page_type');
					$this->filemanager_m->update_row($response['data']['id'],$this->template_data['update_data']);
					$this->session->set_flashdata('success', 'filemanager updated successfully');
					$this->controller_redirect();				
				}
				else{
					throw new Exception("Could not add filemanager <hr/>");
				}
			}			
			$this->breadcrumb->append_crumb('Edit','edit');
			$this->template_data['subview']=self::MODULE.'edit';
			$this->load->view('admin/main_layout',$this->template_data);
		} catch (Exception $e) {
			$this->controller_redirect('Couldnt edit filemanager '.$e->getMessage());
		}
	}

	function activate($slug=NULL){
		try{
			if(!permission_permit(array('activate-filemanager'))) $this->controller_redirect('Permissioin Denied');
			if(!$slug) throw new Exception('Invalid paramter');
			$response=$this->get($slug);
			if(!$response['success']) throw new Exception($response['data'], 1);
			$this->template_data=array('status'=>filemanager_m::ACTIVE);
			$this->filemanager_m->update_row($response['data']['id'],$this->template_data);
			$this->session->set_flashdata('success', 'filemanager activated successfully');
		}
		catch(Exception $e){
			$this->session->set_flashdata('error', 'filemanager not activated '.$e->getMessage());
		}
		$this->controller_redirect();				
	}


	function block($slug=NULL){
		try{
			if(!permission_permit(array('block-filemanager'))) $this->controller_redirect('Permissioin Denied');
			$response=$this->get($slug);
			if(!$response['success']) throw new Exception($response['data'], 1);
			$this->template_data=array('status'=>filemanager_m::BLOCKED);
			$this->filemanager_m->update_row($response['data']['id'],$this->template_data);
			$this->session->set_flashdata('success', 'filemanager blocked successfully');
		}
		catch(Exception $e){
			$this->session->set_flashdata('error', 'filemanager not blocked '.$e->getMessage());
		}
		$this->controller_redirect();				
	}

	function delete($slug=NULL){
		try{
			if(!permission_permit(array('delete-filemanager'))) $this->controller_redirect('Permissioin Denied');
			if(!$slug) throw new Exception('Invalid paramter');
			$response=$this->get($slug);
			if(!$response['success']) throw new Exception($response['data'], 1);
			$this->template_data=array('status'=>filemanager_m::DELETED);
			$this->filemanager_m->update_row($response['data']['id'],$this->template_data);
			$this->session->set_flashdata('success', 'filemanager deleted successfully');
		}
		catch(Exception $e){
			$this->session->set_flashdata('error', 'filemanager not deleted '.$e->getMessage());
		}
		$this->controller_redirect();				
	}

	function controller_redirect($msg=false){
		if($msg) $this->session->set_flashdata('error', $msg);
		$this->template_data['link']=base_url().self::MODULE;
		redirect($this->template_data['link']);				
	}

	function get($slug=FALSE){
		$response['success']=false;
		$response['data']='Error Processing Request';
		if(!$slug) return $response;
		$filemanager=$this->filemanager_m->read_row_by_slug($slug);
		if($filemanager) {
			$response['success']=true;
			$response['data']=$filemanager;
		}
		else{
			$response['data']='filemanager not found';
		}
		return $response;
	}

	function order(){
		// if(!permission_permit(['list-filemanager'])) redirect_to_dashboard();
		$this->template_data['rows']=$this->filemanager_m->read_filemanagers_for_ordering();
		$this->template_data['subview']=self::MODULE.'order';
		$this->breadcrumb->append_crumb('Order','order');
		$this->load->view('admin/main_layout',$this->template_data);		
	}


}
?>