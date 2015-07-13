<?php
class campaign_m extends CI_Model
{
	protected $table='tbl_campaign';

	public $rules=array(
		array(
			'field'=>'campaign_title',
			'label'=>'Campaign Title',
			'rules'=>'trim|xss_clean|required|route|min_length[5]|is_unique[tbl_campaign.campaign_title]'
			),
		array(
			'field'=>'description',
			'label'=>'About your Fundraiser',
			'rules'=>'trim|xss_clean|required'
			),
		array(
			'field'=>'donee',
			'label'=>'Donee',
			'rules'=>'trim|xss_clean|required'
			),
		array(
			'field'=>'target_amount',
			'label'=>'Amount of money',
			'rules'=>'trim|xss_clean|required|greater_than[0]'
			),
		array(
			'field'=>'categories',
			'label'=>'Fundraiser Category',
			'rules'=>'trim|xss_clean|required'
			),
		array(
			'field'=>'starting_at',
			'label'=>'Starting Date',
			'rules'=>'trim|xss_clean|required'
			),
		array(
			'field'=>'ending_at',
			'label'=>'Ending Date',
			'rules'=>'trim|xss_clean|required'
			),
		array(
			'field'=>'url_link',
			'label'=>'URL Link',
			'rules'=>'trim|xss_clean|required|route|url'
			),
		
		);

	const PENDING=0;
	const ACTIVE=1;
	const SUCCESS=2;
	const FAIL=3;
	const BLOCKED=4;
	const DELETED=5;

	const file_path='campaign/';
	const full_path='uploads/files/pics/campaign/';

	public static function status($key=null){
		$status=array(
			self::PENDING=>'PENDING',
			self::ACTIVE=>'ACTIVE',
			self::SUCCESS=>'SUCCESS',
			self::FAIL=>'FAIL',
			self::BLOCKED=>'BLOCKED',
			self::DELETED=>'DELETED',
			);
		if(isset($key)) return $status[$key];
		return $status;
	}

	public static function actions($key=null){
		$actions=array(
			self::PENDING=>'PENDING',
			self::ACTIVE=>'ACTIVE',
			self::SUCCESS=>'SUCCESS',
			self::FAIL=>'FAIL',
			self::BLOCKED=>'BLOCKED',
			self::DELETED=>'DELETED',
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
		->order_by('parent_id','asc')
		->order_by('order','asc');
		$rs=$this->db->get();
		return $rs->result_array();				 
	}

	function read_popular(){
		$rs=$this->db->query("SELECT campaign_id, COUNT( DISTINCT id ) 
			FROM tbl_donation
			GROUP BY campaign_id
			ORDER BY COUNT( DISTINCT id )
			");
//		show_pre($rs->result_array());				 		
		return $rs->result_array();
	}

	function read_all_campaign($limit=0)
	{
		$this->db->select()
		->from($this->table)
		->where("status != ",self::DELETED)
		->where("created_at != ",'0000-00-00')
		->order_by('id','asc')
		->order_by('starting_at','asc')
		->limit($limit);
		$rs=$this->db->get();
		// echo $this->db->last_query();
		return $rs->result_array();				 
	}
	
	function read_all_of_donee($total=0,$start=0,$donee_id=0)
	{		
		//if($this->session->userdata('lastuser_id'))
		$this->db->select()
		->from($this->table)
		->where("user_id",$donee_id)
		->where("status != ",self::DELETED)
		->order_by('id','desc')
		->limit($total,$start);
		$rs=$this->db->get();
		return $rs->result_array();				 
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


	function filter_rows_by($param,$limit=null,$offset=null,$filter=null){
		try {
			if(!is_array($param)) throw new Exception("Error Processing Request, no array", 1);	
			$db_param=$param;
			// show_pre($db_param);
			$this->db->select("c.id,c.campaign_title,c.description,c.status,c.slug,c.target_amount,c.pic,c.created_at,c.starting_at,
				c.ending_at, c.url_link,
				fc.name,
				u.username,
				");
			$this->db->join('tbl_fund_categories as fc','fc.id=c.fund_category_id','inner');
			$this->db->join('tbl_users as u','u.id=c.user_id','inner');
			$this->db->join('tbl_groups as g','g.id=u.group_id','inner');
			
			$this->db->where('fc.status !=',fund_category_m::DELETED);
			$this->db->where('u.status !=',user_m::DELETED);


			if(array_key_exists('status',$param)){
				$db_param['c.status']=$param['status'];
				unset($db_param['status']);
			}else{
				$db_param['c.status !=']=campaign_m::DELETED;				
			}
			if(array_key_exists('campaign_title',$param)){
				$db_param['c.campaign_title like']="{$param['campaign_title']}%";
				unset($db_param['campaign_title']);
			}
			if(array_key_exists('starting_at',$param)){
				$db_param['starting_at >=']=format($param['starting_at'],'Y-m-d');
				unset($db_param['starting_at']);
			}
			if(array_key_exists('ending_at',$param)){
				$db_param['ending_at <=']=format($param['ending_at'],'Y-m-d');
				unset($db_param['ending_at']);
			}
			if(array_key_exists('target_amount',$param)){
				if(array_key_exists('=',$param['target_amount']))
					$db_param['target_amount =']=$param['target_amount']['='];
				elseif(array_key_exists('>=',$param['target_amount']) and array_key_exists('<=',$param['target_amount'])){
					$db_param['target_amount >=']=$param['target_amount']['>='];
					$db_param['target_amount <=']=$param['target_amount']['<='];
				}
				elseif(array_key_exists('>',$param['target_amount']))
					$db_param['target_amount >']=$param['target_amount']['>'];
				elseif(array_key_exists('<',$param['target_amount']))
					$db_param['target_amount <']=$param['target_amount']['<'];
				unset($db_param['target_amount']);
			}


			$this->db->order_by('id','desc');
			$rs = $this->db->get_where("$this->table as c", $db_param, $limit, $offset);				
			// echo "<hr/>".$this->db->last_query();
			if($limit==1 && $rs->num_rows()==1)
				return $rs->first_row('array');
			else{
				return $rs->result_array();		
			}
		}catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());			
			redirect('dashboard');
		}	
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
	
	public function fetch_rows($where = '', $order_by = '', $limit_from = '', $limit_to = '') { 
		//deep
		$this->db->select();
		$this->db->from($this->table);
		$this->db->where($where);
		$this->db->where('status != ',self::DELETED);
		if (strlen($order_by) > 0) {
			$this->db->order_by($order_by);
		}
		if ($limit_from > 0 || $limit_to > 0) {
			$this->db->limit($limit_to, $limit_from);
		}
		$rs=$this->db->get();
		echo $this->db->last_query();	
		return $rs->result_array();	
	}
	public function read_row_by($param='')
	{
		if(!$param) return false;
		$this->db->select()
		->from($this->table)
		->where($param['key'],$param['value'])
		->limit(1);
		$rs=$this->db->get();
		if($rs->num_rows()==0)
			return false;
		return ($rs->result_array());
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
	function read_row_by_name($name='')
	{
		if(!$name) return false;
		$this->db->select()
		->from($this->table)
		->where('name',$name);
		$rs=$this->db->get();
		if($rs->num_rows()==0)
			return false;
		return ($rs->first_row('array'));
	}
	function read_single_campaign_of_donee($campaign_id='', $donee_id='')
	{
		if(!$campaign_id or !$donee_id) return false;
		$this->db->select()
		->from($this->table)
		->where("user_id",$donee_id)
		->where("id",$campaign_id)
		->where("status != ",self::DELETED)
		->order_by('id','desc')
		->limit (1);
		$rs=$this->db->get();
		if($rs->num_rows()==0)
			return false;
		return $rs->result_array();			
	}



	function update_row($id,$data)
	{
		try {
			$this->db->where('id',$id);
			$this->db->update($this->table,$data);
			echo $this->db->last_query();
		} catch (Exception $e) {
			echo $e->getMessage();			
		}
	}
	function update_row_by_userid($id,$data)
	{
		try {
			$this->db->where('user_id',$id);
			$this->db->update($this->table,$data);
		} catch (Exception $e) {
			echo $e->getMessage();			
		}
	}
	function update_campaign($campaign_id, $donee_id, $data)
	{
		//die('ju');
		try {
			$this->db->where('id',$campaign_id);
			$this->db->where('user_id', $donee_id);
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