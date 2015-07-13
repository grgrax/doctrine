<?php
class donation_m extends CI_Model
{

	protected $table='tbl_donation';

	public $rules=array(
		array(
			'field'=>'campaign_title',
			'rules'=>'trim|xss_clean|required|min_length[5]'
			),
		array(
			'field'=>'description',
			'rules'=>'trim|xss_clean|required'
			),
		array(
			'field'=>'target_amount',
			'rules'=>'trim|xss_clean|required|greater_than[2]'
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

	function read_rows_by($param,$limit=null,$offset=null,$filter=null){
		try {
			if(!is_array($param)) throw new Exception("Error Processing Request, no array", 1);	

			$db_param=$param;			
			// echo "<hr>m_param";
			// show_pre($db_param);

			//date filtering
			if(array_key_exists('from_date',$param) or array_key_exists('to_date',$param)){
				if(array_key_exists('from_date',$param))
					$db_param['date >=']=format($param['from_date'],'Y-m-d');
				if(array_key_exists('to_date',$param))
					$db_param['date <=']=format($param['to_date'],'Y-m-d');
				unset($db_param['from_date']);
				unset($db_param['to_date']);	
			}			
			//amount filtering
			if(array_key_exists('amount',$param)){
				if(array_key_exists('=',$param['amount']))
					$db_param['amount =']=$param['amount']['='];
				elseif(array_key_exists('>=',$param['amount']) and array_key_exists('<=',$param['amount'])){
					$db_param['amount >=']=$param['amount']['>='];
					$db_param['amount <=']=$param['amount']['<='];
				}
				elseif(array_key_exists('>',$param['amount']))
					$db_param['amount >']=$param['amount']['>'];
				elseif(array_key_exists('<',$param['amount']))
					$db_param['amount <']=$param['amount']['<'];
				unset($db_param['amount']);
			}
			//join case
			if(array_key_exists('join',$param)){
				$this->db->join('tbl_campaign','tbl_campaign.id=tbl_donation.campaign_id','inner');				
				if(array_key_exists('user_id',$param['join'])){
					$user_id=$param['join']['user_id'];
					$this->db->join('tbl_users','tbl_users.id=tbl_campaign.user_id','inner');
					$this->db->where('tbl_campaign.user_id', $user_id);
				}
				if(array_key_exists('fund_category_id',$param['join'])){
					$fund_category_id=$param['join']['fund_category_id'];
					$this->db->join('tbl_fund_categories','tbl_fund_categories.id=tbl_campaign.fund_category_id','inner');
					$this->db->where('tbl_campaign.fund_category_id', $fund_category_id);
				}
				unset($db_param['join']);
				// echo "<hr>db_param";
				// show_pre($db_param);
				// die;
			}
			$this->db->order_by('tbl_donation.id','desc');
			$rs = $this->db->get_where($this->table, $db_param, $limit, $offset);				
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

	

	public function get_max_min_date($param=null){
		if($param){
			$max_min=$param['max_min'];
			$column=$param['column'];
			$this->db->select("$max_min($column) as dt")->from($this->table)->where('id >','0');
			$rs=$this->db->get();
			// echo $this->db->last_query();
			return $rs->first_row('array');
		}

	}


	function read_all_published()
	{
		$this->db->select()
		->from($this->table)
		->where("status != ",self::DELETED);
		$rs=$this->db->get();
		return $rs->result_array();				 
	}
	public function read_all_by($param=NULL)
	{
		if(!$param) return false;
		$this->db->select()
		->from($this->table)
		->where($param['key'],$param['value']);
		$rs=$this->db->get();
		// echo $this->db->last_query();		
		if($rs->num_rows()==0)
			return false;
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


	public function popular_campaign() {
		//this->db->select('campaign_id',count('DISTINCT id')) 
			//->count('DISTINCT id')
			// ->from($this->table)
			// ->group_by('campaign_id')
			// ->order_by(count('DISTINCT id'));
			// $rs=$this->db->get();
			// echo $this->db->last_query();
			// return $rs->result_array();

		$query = $this->db->query(" SELECT tbl_donation.campaign_id, COUNT( DISTINCT tbl_donation.id ) no_of_donar, 
			SUM(  tbl_donation.amount ) total_amount
			FROM tbl_donation 
			INNER JOIN tbl_campaign
			ON tbl_campaign.id = tbl_donation.campaign_id AND tbl_campaign.status = 1 
			INNER JOIN tbl_fund_categories
			ON tbl_campaign.fund_category_id = tbl_fund_categories.id AND tbl_fund_categories.status = 1
			GROUP BY tbl_donation.campaign_id ORDER BY COUNT( DISTINCT tbl_donation.id ) desc 
			
			");
		$pop_campaign = array();
		foreach ($query->result() as $row)
		{
			$pop_campaign[] = $row;
				// show_pre($row);
		}
		// die();
		return $pop_campaign;
	}
	public function total_donation_amount($campaign_id) {

// SELECT SUM(  `amount` ) total_amount
// FROM tbl_donation
// WHERE campaign_id =62
// GROUP BY campaign_id
		$query = $this->db->query("SELECT SUM(  `amount` ) total_amount
			FROM tbl_donation
			WHERE campaign_id =$campaign_id
			GROUP BY campaign_id
			");
		foreach ($query->result() as $row)
		{
			return $row->total_amount;
				 // $pop_campaign[] = $row;
				// show_pre($row);
		}
		// $this->db->select(sum('amount'))
		// 	->from($this->table)
		// 	->where('campaign_id=', $campaign_id)
		// 	->where("status != ",self::DELETED)
		// 	->group_by('campagin_id');
		// $rs=$this->db->get();
		// return $rs->num_rows();			
	}

	

}
?>