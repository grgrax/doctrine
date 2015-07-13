<?php
class bank_details_m extends CI_Model
{
	protected $table='tbl_bank_details';

	public $rules=array(
		// array(
		// 	'field'=>'BSB',
		// 	'label'=>'BSB',
		// 	'rules'=>'trim|xss_clean|required'
		// 	),
		array(
			'field'=>'bank_name',
			'label'=>'Bank Name',
			'rules'=>'trim|xss_clean|alpha'
			),
		array(
			'field'=>'acc_no',
			'label'=>'Account no',
			'rules'=>'trim|xss_clean|alpha_dash|exact_length[5]|greater_than[0]'
			),
		array(
			'field'=>'acc_holder_name',
			'label'=>'Account holdername',
			'rules'=>'trim|xss_clean|alpha'
			)
		);

	const UNPUBLISHED=0;
	const PUBLISHED=1;
	const DELETED=2;

	const file_path='categories/';

	public static function status($key=null){
		$status=array(
			self::PUBLISHED=>'PUBLISHED',
			self::UNPUBLISHED=>'UNPUBLISHED',
			);
		if(isset($key)) return $status[$key];
		return $status;
	}

	public static function actions($key=null){
		$actions=array(
			self::PUBLISHED=>'PUBLISHED',
			self::UNPUBLISHED=>'UNPUBLISHED',
			);
		if(isset($key)) return $actions[$key];
		return $actions;
	}

	public function __construct(){
		$this->path=base_url()."uploads/pics/testimonials/";
	}

	function read_all($total=0,$start=0)
	{
		$this->db->select()
		->from($this->table)
		->where("status != ",self::DELETED)
		->order_by('id','desc')
		->limit($total,$start);
		$rs=$this->db->get();
		return $rs->result_array();				 
	}

	function read_all_published()
	{
		$this->db->select()
		->from($this->table)
		->where("status != ",self::DELETED)
		->where("published = ",self::PUBLISHED)
		->order_by('parent_id','asc')
		->order_by('order','asc');
		$rs=$this->db->get();
		return $rs->result_array();				 
	}

	function read_all_published_childs($cat_id)
	{
		$this->db->select()
		->from($this->table)
		->where("status != ",self::DELETED)
		->where("published = ",self::PUBLISHED)
		->where("parent_id = ",$cat_id)
		->order_by('id','asc')
		->order_by('order','asc');
		$rs=$this->db->get();
		return $rs->result_array();				 
	}


	//order
	function read_categories_for_ordering()
	{

        //$this->db->select('id,parent_id,order');
		$this->db->from($this->table);
		$this->db->order_by("order", "asc");
		$query = $this->db->get();
		$categorys=$query->result_array();
		$final_categorys=array();
		foreach ($categorys as $category) {
			if(!$category['parent_id']){
				$final_categorys[$category['id']]=$category;
			}
			else
			{
				$final_categorys[$category['parent_id']]['children'][]=$category;
			}
		}
		// show_pre($final_categorys);
		return ($final_categorys);
	}
	public function save_order($categorys)
	{
		$response['success']=false;
		$response['data']='Error Processing Request';
		try {
			if (count($categorys)) {
				foreach ($categorys as $order => $category) {
					$id=$category['item_id'];
					if ($id) {
						$data = array(
							'parent_id' =>  $category['parent_id']?$category['parent_id']:NULL,
							'order' => $order);
						$this->db->set($data)->where('id',$id)->update($this->table);
					}
				}
				$response['success']=true;
				$response['data']="category order successfully update";
			}
		} catch (Exception $e) {
			echo $e->getMessage();
			$response['data']=$e->getMessage();
		}
		return $response;
	}


	//order


	public function get_parents()
	{
		$this->db->select('id,name')->from($this->table)->where("status =".self::ACTIVE." and parent_id is NULL");
		$rs=$this->db->get();
		return $rs->result_array();				 
	}

	public function get_parent_name($id=NULL)
	{
		$this->db->select('name')->from($this->table)->where("id =$id")->limit('1');
		$rs=$this->db->get();
		return $rs->row('name');				 				 
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
	function read_row($id)
	{
		$this->db->select()
		->from($this->table)
		->where('id',$id);
		$rs=$this->db->get();
		return ($rs->first_row('array'));
	}
	function read_row_by_slug($slug='')
	{
		if(!$slug) return false;
		$this->db->select()
		->from($this->table)
		->where('slug',$slug);
		$rs=$this->db->get();
		if($rs->num_rows()==0)
			return false;
		return ($rs->first_row('array'));
	}
	function read_row_by_name($username='')
	{
		if(!$username) return false;
		$this->db->select()
		->from($this->table)
		->where('username',$username);
		$rs=$this->db->get();
		if($rs->num_rows()==0)
			return false;
		return ($rs->first_row('array'));
	}
	function read_row_by_id($id='')
	{
		if(!$id) return false;
		$this->db->select()
		->from($this->table)
		->where('id',$id);
		$rs=$this->db->get();
		if($rs->num_rows()==0)
			return false;
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

	public function set_rules(array $escape_rules=NUll){

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


	
	function read_rows_by($param,$limit=null,$offset=null){
		try {
			if(!is_array($param)) throw new Exception("Error Processing Request, no array", 1);	
			$rs = $this->db->get_where($this->table, $param, $limit, $offset);
			// echo $this->db->last_query();
			if($limit==1 && $rs->num_rows()==1)
				return $rs->first_row('array');
			else
				return $rs->result_array();		
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());			
			redirect();
		}	
	}


	public function get_rules(array $get_rules=NUll){
		if(!$get_rules){
			return $this->rules;
		}
		else{
			$applied_rules=[];
			foreach($this->rules as $rule){
				if(in_array($rule['field'],$get_rules)) 
					$applied_rules[]=$rule;
			}
			return $applied_rules;
		}
	}

}
?>