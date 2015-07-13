<?php
class fund_category extends Admin_Controller
{
	const MODULE='report/';

	function __construct()
	{
		parent::__construct();
		// if(!permission_permit(['administrator-article'])) redirect_to_dashboard();
		$this->load->helper(array('fund_category'));
		$this->load->model('fund_category/fund_category_report_m');
		$this->template_data['fund_category_report_m']=$this->fund_category_report_m;
		$this->template_data['link']=base_url().self::MODULE;
		$this->breadcrumb->append_crumb('Most campaigns',base_url().self::MODULE.'fund_category');
	}

	function most_campaigns($offset=0)
	{
		// if(!permission_permit(['list-article'])) redirect_to_dashboard();
		$per_page=10;
		$total_rows=$this->fund_category_report_m->most_campaigns_report(null,$offset);
		// echo "<hr/>tr: $total_rows";
		$this->template_data['rows']=$this->fund_category_report_m->most_campaigns_report($per_page,$offset);
		// echo "<hr/>";
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
		$this->template_data['subview']=self::MODULE.'fund_category/most_campaigns';
		$this->load->view('admin/main_layout',$this->template_data);
	}

	function most_donations($offset=0)
	{
		// if(!permission_permit(['list-article'])) redirect_to_dashboard();
		$per_page=10;
		$total_rows=$this->fund_category_report_m->most_donations_report(null,$offset);
		// echo "<hr/>tr: $total_rows";
		$this->template_data['rows']=$this->fund_category_report_m->most_donations_report($per_page,$offset);
		// echo "<hr/>";
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
		$this->template_data['subview']=self::MODULE.'fund_category/most_campaigns';
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