<?php
class report extends Admin_Controller
{
	const MODULE='article/';

	function __construct()
	{
		parent::__construct();
		// if(!permission_permit(['administrator-article'])) redirect_to_dashboard();
		$this->load->helper(array('article','category/category'));
		$this->load->model('article_m');
		$this->load->model('category/category_m');
		$this->template_data['article_m']=$this->article_m;
		$this->template_data['category_m']=$this->category_m;
		$this->template_data['actions']=article_m::actions();
		$this->template_data['link']=base_url().self::MODULE;
		$this->template_data['categories']=$this->category_m->read_all($this->category_m->count_rows());
		$this->template_data['rows']=$this->article_m->read_all($this->article_m->count_rows());
		$this->breadcrumb->append_crumb('List Articles',base_url().self::MODULE.'index');
	}

	function fund_category()
	{
		if(!permission_permit(['list-article'])) redirect_to_dashboard();
		$per_page=20;
		$total_rows=$this->article_m->count_rows();
		$this->template_data['rows']=$this->article_m->read_all($per_page,$offset);
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

	
	function controller_redirect($msg=false){
		if($msg) $this->session->set_flashdata('error', $msg);
		$this->template_data['link']=base_url().self::MODULE;
		redirect($this->template_data['link']);				
	}

	function get($slug=FALSE){
		$response['success']=false;
		$response['data']='Error Processing Request';
		if(!$slug) return $response;
		$article=$this->article_m->read_row_by_slug($slug);
		if($article) {
			$response['success']=true;
			$response['data']=$article;
		}
		else{
			$response['data']='article not found';
		}
		return $response;
	}

}
?>