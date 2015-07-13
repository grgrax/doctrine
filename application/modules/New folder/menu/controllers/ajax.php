<?php
class ajax extends Xhr{
	
	public function __construct(){
		parent::__construct();
		try {
			$this->load->model('menu_m');
			$this->template_data['menu_m']=$this->menu_m;			
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function order_ajax ()
	{
		try {
			if (isset($_POST['sortable'])) {
				$response=$this->menu_m->save_order($_POST['sortable']);
                if(!$response['success']) throw new Exception($response['data'], 1);
                $data['success']=$response['data'];
			}
			$data['rows']=$this->menu_m->read_menus_for_ordering();
			$this->load->view('menu/ajax/order', $data);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}	