<?php
class category extends Admin_Controller
{
	const MODULE='category/';

	function __construct()
	{
		parent::__construct();
		if(!permission_permit(['administrator-category'])) redirect_to_dashboard();
		$this->load->helper(array('category'));
		$this->load->model('category_m');
		$this->template_data['category_m']=$this->category_m;
		$this->template_data['actions']=category_m::actions();
		$this->template_data['link']=base_url().self::MODULE;
		$this->template_data['rows']=$this->category_m->read_all($this->category_m->count_rows());
		$this->breadcrumb->append_crumb('List Categories',base_url().self::MODULE.'index');
	}

	function index($offset=0)
	{
		if(!permission_permit(['list-category'])) redirect_to_dashboard();
		$per_page=20;
		$total_rows=$this->category_m->count_rows();
		$this->template_data['rows']=$this->category_m->read_all($per_page,$offset);
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
		$this->template_data['subview']=self::MODULE.'list';
		$this->load->view('admin/main_layout',$this->template_data);
	}

	function add()
	{
		try {
			if(!permission_permit(array('list-category','add-category'))) $this->controller_redirect('Permissioin Denied');
			if($this->input->post())
			{
				$rules=$this->category_m->set_rules();
				$name=array(
					'field'=>'name',
					'label'=>'Category Name',
					'rules'=>'trim|required|is_unique[tbl_categories.name]|xss_clean'
					);
				array_push($rules,$name);
				$this->form_validation->set_rules($rules);
				if($this->form_validation->run($this)===TRUE)
				{
					$current_user=current_loggedin_user();
					$this->template_data['insert_data']=array(
						'parent_id'=>$this->input->post('parent_id')?$this->input->post('parent_id'):NULL,
						'name'=>$this->input->post('name'),
						'slug'=>get_slug($this->input->post('name')),
						'content'=>$this->input->post('content'),
						'image'=>$_FILES['image']['name'],
						'image_title'=>$this->input->post('image_title'),
						'url'=>$this->input->post('url'),
						'order'=>$this->category_m->count_rows()+1,
						'published'=>1,
						'author'=>$current_user['id'],
						'status'=>1,
						);
					$path=get_relative_upload_file_path();
					$path.=category_m::file_path;
					if($_FILES['image']['name'])
						upload_picture($path,'image');
					$this->category_m->create_row($this->template_data['insert_data']);
					$this->session->set_flashdata('success', 'category added successfully');
					$this->controller_redirect();				
				}else{
					throw new Exception(validation_errors());
				}
			}			
			$this->breadcrumb->append_crumb('Add','add');
			$this->template_data['subview']=self::MODULE.'add';
			$this->load->view('admin/main_layout',$this->template_data);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'Couldnt add category '.$e->getMessage());
			$this->controller_redirect();
		}
	}

	function edit($slug=FALSE)
	{
		try {
			if(!permission_permit(array('list-category','edit-category'))) throw new Exception("Permissioin Denied", 1);
			if(!$slug) throw new Exception("Error Processing Request", 1);
			$response=$this->get($slug);
			if(!$response['success']) throw new Exception($response['data'], 1);
			$this->template_data['row']=$response['data'];
			$id=$response['data']['id'];
			
			if($this->input->post())
			{
				$rules=$this->category_m->set_rules();
				$name=$this->input->post('name');
				$name_rule=array(
					'field'=>'name',
					'label'=>'Category Name',
					'rules'=>"trim|required|xss_clean|is_category_name_unique[$id]",
					);
				array_push($rules,$name_rule);
				show_pre($rules);

				$this->form_validation->set_rules($rules);
				if($this->form_validation->run($this)===TRUE)
				{
					$this->template_data['update_data']=array(
						'parent_id'=>$this->input->post('parent_id')?$this->input->post('parent_id'):NULL,
						'content'=>$this->input->post('content'),
						'image'=>$_FILES['image']['name'],
						'image_title'=>$this->input->post('image_title'),
						'url'=>$this->input->post('url'),
						);
					$path=get_relative_upload_file_path();
					$path.=category_m::file_path;
					if($_FILES['image']['name'])
						upload_picture($path,'image');
					if(!is_default($slug)){
						$this->template_data['update_data']['name']=$this->input->post('name');
						$this->template_data['update_data']['slug']=get_slug($this->input->post('name'));
					}
					$this->category_m->update_row($id,$this->template_data['update_data']);
					$this->session->set_flashdata('success', 'category updated successfully');
					$this->controller_redirect();				
				}
				else{
					throw new Exception(validation_errors());
				}
			}			
			$this->breadcrumb->append_crumb('Edit','edit');
			$this->template_data['subview']=self::MODULE.'edit';
			$this->load->view('admin/main_layout',$this->template_data);
		} catch (Exception $e) {
			$this->controller_redirect('Couldnt edit category '.$e->getMessage());
		}
	}

	function publish($slug=NULL){
		try{
			if(!permission_permit(array('activate-category'))) $this->controller_redirect('Permissioin Denied');
			if(!$slug) throw new Exception('Invalid paramter');
			$response=$this->get($slug);
			if(!$response['success']) throw new Exception($response['data'], 1);
			$this->template_data=array('published'=>category_m::PUBLISHED);
			$this->category_m->update_row($response['data']['id'],$this->template_data);
			$this->session->set_flashdata('success', 'category published successfully');
		}
		catch(Exception $e){
			$this->session->set_flashdata('error', 'category not published '.$e->getMessage());
		}
		$this->controller_redirect();				
	}


	function unpublish($slug=NULL){
		try{
			if(!permission_permit(array('block-category'))) $this->controller_redirect('Permissioin Denied');
			$response=$this->get($slug);
			if(!$response['success']) throw new Exception($response['data'], 1);
			$this->template_data=array('published'=>category_m::UNPUBLISHED);
			$this->category_m->update_row($response['data']['id'],$this->template_data);
			$this->session->set_flashdata('success', 'category unpublished successfully');
		}
		catch(Exception $e){
			$this->session->set_flashdata('error', 'category not unpublished '.$e->getMessage());
		}
		$this->controller_redirect();				
	}

	function delete($slug=NULL){
		try{
			if(!permission_permit(array('delete-category'))) $this->controller_redirect('Permissioin Denied');
			if(!$slug) throw new Exception('Invalid paramter');
			$response=$this->get($slug);
			if(!$response['success']) throw new Exception($response['data'], 1);
			$this->template_data=array('status'=>category_m::DELETED);
			$this->category_m->update_row($response['data']['id'],$this->template_data);
			$this->session->set_flashdata('success', 'category deleted successfully');
		}
		catch(Exception $e){
			$this->session->set_flashdata('error', 'category not deleted '.$e->getMessage());
		}
		$this->controller_redirect();				
	}

	function modal(){
		$this->template_data['subview']=self::MODULE.'hello';
		$this->load->view('admin/modal_layout',$this->template_data);
	}

	function upload(){
		$config['upload_path'] = "./uploads/pics/categorys/";
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('std_pic'))
		{
			$data['error']=$this->upload->display_errors();
			throw new Exception("Could not add category <hr/>".$data['error']);
		}
		else{
			$data['success'] = array('upload_data' => $this->upload->data());
		}
	}

	function set_upload_rule(){
		if (empty($_FILES['std_pic']['name']))
			$this->form_validation->set_rules('std_pic', 'Student Picture', 'trim|required|xss_clean');
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
		$category=$this->category_m->read_row_by_slug($slug);
		if($category) {
			$response['success']=true;
			$response['data']=$category;
		}
		else{
			$response['data']='category not found';
		}
		return $response;
	}



}
?>