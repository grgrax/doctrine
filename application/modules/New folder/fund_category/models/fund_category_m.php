<?php
class fund_category_m extends CI_Model
{

	protected $table='tbl_fund_categories';

	public $rules=array(
		array(
			'field'=>'name',
			'label'=>'Name',
			'rules'=>'trim|required|route|is_unique[tbl_fund_categories.name]|min_length[3]|xss_clean',
			),
		array(
			'field'=>'description',
			'label'=>'Description',
			'rules'=>'trim|required|xss_clean',
			),
		);

	const UNPUBLISHED=0;
	const PUBLISHED=1;
	const DELETED=2;

	const file_path='fund_category/';

	//filters
	const CAMPAGIN = 1;
	const DONATION = 2;
	const SUCCESSFUL = 3;
	const AMOUNT_FIXED = 4;
	const AMOUNT_RAISED = 5;

	static function status($key=null){
		$status=array(
			self::UNPUBLISHED=>'UNPUBLISHED',
			self::PUBLISHED=>'PUBLISHED',
			self::DELETED=>'DELETED',
			);
		if(isset($key)) return $status[$key];
		return $status;
	}

	static function actions($key=null){
		$actions=array(
			self::PUBLISHED=>'PUBLISHED',
			self::UNPUBLISHED=>'UNPUBLISHED',
			);
		if(isset($key)) return $actions[$key];
		return $actions;
	}

	static function get_filter($key=null){		
		$filter=array(
			self::CAMPAGIN=>'CAMPAGIN',
			self::DONATION=>'DONATION',
			self::SUCCESSFUL=>'SUCCESSFUL',
			self::AMOUNT_FIXED=>'AMOUNT_FIXED',
			self::AMOUNT_RAISED=>'AMOUNT_RAISED',
			);
		if(isset($key)) return $filter[$key];
		return $filter;
	}

	function __construct(){
		$this->path=base_url()."uploads/pics/testimonials/";
	}

	function read_all_filter($limit=0,$offset=0,$filters=null)
	{
		if(!$filters)
			$filters["status !="]=self::DELETED;
		show_pre($filters);
		$db_filters=array();
		foreach ($filters as $key => $value) {
			if($key=='status')
				$db_filters[$key]=$value;
			else if($value)
				$db_filters[$key]=$value;
		}
		$rs = $this->db->get_where($this->table, $db_filters, $limit, $offset);
		echo $this->db->last_query();
		return $rs->result_array();				 
	}

	function count_filter_result($limit=0,$filters=null)
	{
		if(!$filters)
			$filters["status !="]=self::DELETED;
		show_pre($filters);
		$db_filters=array();
		foreach ($filters as $key => $value) {
			if($key=='status')
				$db_filters[$key]=$value;
			else if($value)
				$db_filters[$key]=$value;
		}
		$rs = $this->db->get_where($this->table, $db_filters, $limit);
		echo $this->db->last_query();
		return $rs->result_array();				 
	}

	function read_all($limit=0,$offset=0)
	{
		$this->db->select()
		->from($this->table)
		->where("status != ",self::DELETED)
		->order_by('id','desc')
		->limit($limit,$offset);
		$rs=$this->db->get();
		return $rs->result_array();				 
	}

	function read_all_published()
	{
		$this->db->select()
		->from($this->table)
		->where("status",self::PUBLISHED);
		$rs=$this->db->get();
		return $rs->result_array();				 
	}


	function count_rows()
	{
		$this->db->select()
		->from($this->table)
		->where("status != ",self::DELETED)
		->order_by('id','desc');
		$rs=$this->db->get();
		return $rs->num_rows();				 
	}	
	function create_row($data)
	{
		$this->db->insert($this->table,$data);
	}
	function read_rows_by($param,$limit=null,$offset=null){
		try {
			if(!is_array($param)) throw new Exception("Error Processing Request, no array", 1);	
			$rs = $this->db->get_where($this->table, $param, $limit, $offset);
			if($limit==1 && $rs->num_rows()==1)
				return $rs->first_row('array');
			else
				return $rs->result_array();	
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());			
			redirect();
		}	
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
			show_pre($data);
			// exit;
		} catch (Exception $e) {
			echo $e->getMessage();			
		}
	}
	function delete_row($id)
	{
		$this->db->where('id',$id);
		$this->db->update($this->table,array('status' =>self::DELETED));

	}

	function set_rules(array $escape_rules=NUll){

		//$rules=array();
		if($escape_rules && is_array($escape_rules)){
			//$rules=$mode=="edit"?$this->rules:$this->add_rules;
			foreach($this->rules as $rule){
				if(in_array($rule['field'],$escape_rules)) continue;
				$applied_rules[]=$rule;
			}
			return $applied_rules;
		}
		return $this->rules;
	}

	

}
?>