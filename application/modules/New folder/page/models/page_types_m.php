<?php
class page_types_m extends CI_Model
{

	protected $table='tbl_page_types';

	function read_all()
	{
		$this->db->select()
		->from($this->table);
		$rs=$this->db->get();
		return $rs->result_array();				 
	}

	function count_rows()
	{
		$this->db->select()
		->from($this->table)
		->where("status != ",3)
		->order_by('id','desc');
		$rs=$this->db->get();
		return $rs->num_rows();				 
	}	
	function create_row($data)
	{
        $this->db->insert($this->table
			,$data);
	}
	function read_row($id)
	{
		$this->db->select()
		->from($this->table)
		->where('id',$id);
		$rs=$this->db->get();
		return ($rs->first_row('array'));
	}
    function update_row($id,$data)
	{
		try {
			$this->db->where('id',$id);
			$this->db->update($this->table,$data);
		} catch (Exception $e) {
			echo $e->getMessage();			
		}
	}
	function delete_row($id)
	{
		$this->db->where('id',$id);
		$this->db->update($this->table,array('status' =>self::DELETED));
		
	}


}
?>