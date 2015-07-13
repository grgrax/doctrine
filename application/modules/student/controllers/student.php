<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class student extends Admin_Controller {

	private $data;
	const MODULE='student/';

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation','session','breadcrumb'));
		$this->data['link']=base_url().self::MODULE;
	}

	public function index(){
		$this->data['subview']=self::MODULE.'list';
		$this->load->view('admin/main_layout',$this->data);
	}

}

/* End of file sample.php */
/* Location: ./application/modules/sample/controllers/sample.php */