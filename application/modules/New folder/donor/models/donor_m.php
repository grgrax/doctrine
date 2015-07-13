<?php 
class donor_m extends MY_Model {

	protected $table='tbl_donar';


	function read_rows_by($param,$limit=null,$offset=null){
		try {
			if(!is_array($param)) throw new Exception("Error Processing Request, no array", 1);	
			$rs = $this->db->get_where($this->table, $param, $limit, $offset);
			return $rs->result_array();		
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());			
			redirect();
		}	
	}
}

/* End of file sample.php */
/* Location: ./application/modules/sample/models/sample.php */