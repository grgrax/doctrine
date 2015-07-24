<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// use student\models\student;

class frontend extends Frontend_Controller {

	public $data;
	private $em=null;
	const MODULE='frontend/';

	function __construct()
	{
		parent::__construct();
		$this->em=$this->doctrine->em;
	}

	function index()
	{
		$this->data['subview']=self::MODULE.'list';			
		$this->load->view('front/main_layout',$this->data);		
	}

	// 1-1 student:mentor
	function onetoone()
	{
		$this->data['students']=$students=$this->em->getRepository('student\models\student')->findAll();
		// show_pre(var_dump($students));
		// Doctrine\Common\Util\Debug::dump($students);
		$this->data['subview']=self::MODULE.'student/list';			
		$this->load->view('front/main_layout',$this->data);		
	}
	function student($id){
		$this->data['students']=$students=$this->em->getRepository('student\models\student')->findAll();
		$this->data['student']=$student=$this->em->find('student\models\student',$id);	
		$this->data['subview']=self::MODULE.'student/edit';			
		$this->load->view('front/main_layout',$this->data);		
	}
	function student_add(){
		try {
			$this->data['students']=$students=$this->em->getRepository('student\models\student')->findAll();
			if($this->input->post()){
				$student = new student\models\student;
				$student->setName($this->input->post('name')?$this->input->post('name'):null);
				if($this->input->post('mentor'))
					$mentor=$this->em->find('student\models\student',$this->input->post('mentor'));
				$student->setMentor($mentor);
				$this->em->persist($student);
				$this->em->flush();
				$this->session->set_flashdata('success', 'article added successfully');
				redirect('frontend/onetoone');
			}
			$this->data['subview']=self::MODULE.'student/add';			
			$this->load->view('front/main_layout',$this->data);		
			
		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'coulnt add student');
			redirect('frontend/onetoone');			
		}
	}	
	// 1-1 student:mentor

	// 1-1 uni product:shipping
	function onetooneuni()
	{
		$this->data['products']=$products=$this->em->getRepository('frontend\models\product')->findAll();
		$this->data['subview']=self::MODULE.'product/list';			
		$this->load->view('front/main_layout',$this->data);		
	}
	function product_add(){
		try {
			if($this->input->post()){
				//shipping details
				$shipping = new frontend\models\shipping;
				$shipping->setName($this->input->post('shipping')?$this->input->post('shipping'):NULL);
				$shipping->setTime(new \DateTime('now'));
				$this->em->persist($shipping);

				//product details
				$product = new frontend\models\product;
				$product->setName($this->input->post('name')?$this->input->post('name'):NULL);
				$product->setShipping($shipping);
				$this->em->persist($product);

				if($product->getName()!==NULL){
					$this->em->flush();
				}else{
					throw new Exception("Error Processing Request", 1);					
				}
				$this->session->set_flashdata('success', 'prodcut added successfully');
				redirect('frontend/onetooneuni');
			}
			$this->data['subview']=self::MODULE.'product/add';			
			$this->load->view('front/main_layout',$this->data);		
			
		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'coulnt add product');
			redirect('frontend/onetooneuni');			
		}
	}
	function product($id){
		$this->data['shippings']=$shippings=$this->em->getRepository('frontend\models\shipping')->findAll();
		$this->data['product']=$product=$this->em->find('frontend\models\product',$id);	
		$this->data['subview']=self::MODULE.'product/edit';			
		$this->load->view('front/main_layout',$this->data);		
	}
	// 1-1 uni product:shipping

	// 1-1 bi cart:customer
	function onetoonebi()
	{
		$this->data['carts']=$carts=$this->em->getRepository('frontend\models\cart')->findAll();
		$this->data['subview']=self::MODULE.'cart/list';			
		$this->load->view('front/main_layout',$this->data);		
	}
	function cart_add(){
		try {
			$this->data['customers']=$customers=$this->em->getRepository('frontend\models\customer')->findAll();
			if($this->input->post()){
				$cart = new \frontend\models\cart;
				$customer = new \frontend\models\customer;

				$cart->setCartNumber($this->input->post('no')?$this->input->post('no'):NULL);
				$customer->setName($this->input->post('customer')?$this->input->post('customer'):NULL);

				$cart->setCustomer($customer);
				$this->em->persist($customer);


				$this->em->persist($cart);
				$this->em->flush();
				$this->session->set_flashdata('success', 'article added successfully');
				redirect('frontend/onetoonebi');
			}
			$this->data['subview']=self::MODULE.'cart/add';			
			$this->load->view('front/main_layout',$this->data);		
			
		} catch (Exception $e) {
			die($e->getMessage());
			$this->session->set_flashdata("error {$e->getMessage()}", 'coulnt add cart');
			redirect('frontend/onetoonebi');			
		}
	}
	// 1-1 bi cart:customer

	// 1-1 bi customer:cart
	function onetoonebicustomers()
	{
		$this->data['customers']=$customers=$this->em->getRepository('frontend\models\customer')->findAll();
		$this->data['subview']=self::MODULE.'cart/customer/list';			
		$this->load->view('front/main_layout',$this->data);		
	}
	function customer_add(){
		try {
			$this->data['customers']=$customers=$this->em->getRepository('frontend\models\customer')->findAll();
			if($this->input->post()){
				
				$customer = new \frontend\models\customer;
				$customer->setName($this->input->post('customer')?$this->input->post('customer'):NULL);
				
				$cart = new \frontend\models\cart;
				$cart->setCartNumber($this->input->post('no')?$this->input->post('no'):NULL);

				$cart->setCustomer($customer);
				$customer->setCart($cart);

				$this->em->persist($cart);				
				
				$this->em->persist($customer);
				$this->em->flush();

				$this->session->set_flashdata('success', 'customer added successfully');
				redirect('frontend/onetoonebi');
			}
			$this->data['subview']=self::MODULE.'cart/customer/add';			
			$this->load->view('front/main_layout',$this->data);		
			
		} catch (Exception $e) {
			die($e->getMessage());
			$this->session->set_flashdata("error {$e->getMessage()}", 'coulnt add customer');
			redirect('frontend/onetoonebicustomers');			
		}
	}
	// 1-1 bi customer:cart

	// 1-8 join user:phonenos
	function onetoonetbljoinuserpnos()
	{
		$this->data['users']=$users=$this->em->getRepository('frontend\models\user')->findAll();
		$this->data['subview']=self::MODULE.'user/list';			
		$this->load->view('front/main_layout',$this->data);		
	}
	function add_user(){
		try{
			if($this->input->post()){
				$user = new frontend\models\user;
				$user->setUsername($this->input->post('name')?$this->input->post('name'):NULL);
				$this->em->persist($user);
				$this->em->flush();
				$this->session->set_flashdata('success', 'user added successfully');
				redirect('frontend/onetoonetbljoinuserpnos');
			}
			$this->data['subview']=self::MODULE.'user/add';			
			$this->load->view('front/main_layout',$this->data);		
		} catch (Exception $e) {
			$this->session->set_flashdata('error', "coulnt add user {$e->getMessage()}");
			redirect('frontend/onetoonetbljoinuserpnos');			
		}
	}
	function add_phone($user){
		try{
			$user = $this->em->find('frontend\models\user',$user);
			if(!$user) throw new Exception("no user found", 1);
			$this->data['user']=$user;			
			if($this->input->post()){
				
				
				$phoneno = new frontend\models\phoneno;
				$phoneno->setNumber($this->input->post('phoneno'));
				//must
				$this->em->persist($phoneno);

				$user->addPhoneno($phoneno);
				$this->em->persist($user);
				
				$this->em->flush();
				$this->session->set_flashdata('success', 'user added successfully');
				redirect('frontend/onetoonetbljoinuserpnos');
			}
			$this->data['subview']=self::MODULE.'user/phoneno/add';			
			$this->load->view('front/main_layout',$this->data);		
		} catch (Exception $e) {
			$this->session->set_flashdata('error', "coulnt add user {$e->getMessage()}");
			redirect('frontend/onetoonetbljoinuserpnos');			
		}
	}
	// 1-8 join user:phonenos

	// 1-8 product:features
	function onetomanyfromeproduct()
	{
		$this->data['eproducts']=$products=$this->em->getRepository('frontend\models\eproduct')->findAll();
		$this->data['subview']=self::MODULE.'eproduct/list';			
		$this->load->view('front/main_layout',$this->data);		
	}
	function add_eproduct(){
		try{
			if($this->input->post()){

				//eproduct details
				$eproduct = new frontend\models\eproduct;
				$eproduct->setName($this->input->post('name')?$this->input->post('name'):NULL);
				$this->em->persist($eproduct);
				$this->em->flush();

				$this->session->set_flashdata('success', 'eproduct added successfully');
				redirect('frontend/onetomanyfromeproduct');
			}
			$this->data['subview']=self::MODULE.'eproduct/add';			
			$this->load->view('front/main_layout',$this->data);		

		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'coulnt add eproduct {$e->getMessage()}');
			redirect('frontend/onetomanyfromeproduct');			
		}
	}
	function add_feature($eproduct){
		try {
			$eproduct = $this->em->find('frontend\models\eproduct',$eproduct);
			if(!$eproduct) throw new Exception("no eproduct found", 1);
			$this->data['eproduct']=$eproduct;			
			if($this->input->post()){

				//feature details
				$feature = new frontend\models\feature;
				$feature->setName($this->input->post('feature')?$this->input->post('feature'):NULL);
				$this->em->persist($feature);

				//eproduct details
				$feature->setEproduct($eproduct);


				$this->em->flush();
				$this->session->set_flashdata('success', 'eproduct added successfully with feature');
				redirect('frontend/onetomanyfromeproduct');
			}
			$this->data['subview']=self::MODULE.'eproduct/feature/add';			
			$this->load->view('front/main_layout',$this->data);		
			
		} catch (Exception $e) {
			die($e->getMessage());
			$this->session->set_flashdata('error {$e->getMessage()}', 'coulnt add eproduct');
			redirect('frontend/onetomanyfromproduct');			
		}
	}
	function add_eproduct_add_feature(){
		try{
			if($this->input->post()){

				//eproduct details
				$eproduct = new frontend\models\eproduct;
				$eproduct->setName($this->input->post('name')?$this->input->post('name'):NULL);
				foreach ($this->input->post('features') as $f) {
					$feature = new frontend\models\feature;
					$feature->setName($f);
					$feature->setEproduct($eproduct);
					$this->em->persist($feature);
				}
				$this->em->persist($eproduct);
				$this->em->flush();

				$this->session->set_flashdata('success', 'eproduct added successfully');
				redirect('frontend/onetomanyfromeproduct');
			}
			$this->data['subview']=self::MODULE.'eproduct/add_with_feature';			
			$this->load->view('front/main_layout',$this->data);		

		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'coulnt add eproduct {$e->getMessage()}');
			redirect('frontend/onetomanyfromeproduct');			
		}

	}
	// 1-8 product:features


	// 1-8 features:product
	function onetomanyfromfeature()
	{
		$this->data['features']=$features=$this->em->getRepository('frontend\models\feature')->findAll();
		$this->data['subview']=self::MODULE.'eproduct/feature/all';			
		$this->load->view('front/main_layout',$this->data);		
	}
	// 1-8 features:product
	
	// 1-8 self category:parent-childs
	function onetomanyselfcategory()
	{
		$this->data['cats']=$products=$this->em->getRepository('frontend\models\category')->findAll();
		$this->data['subview']=self::MODULE.'category/list';			
		$this->load->view('front/main_layout',$this->data);		
	}
	function add_category(){
		try{
			if($this->input->post()){
				$category = new frontend\models\category;
				$category->setName($this->input->post('name')?$this->input->post('name'):NULL);
				$this->em->persist($category);
				$this->em->flush();

				$this->session->set_flashdata('success', 'category added successfully');
				redirect('frontend/onetomanyselfcategory');
			}
			$this->data['subview']=self::MODULE.'category/add';			
			$this->load->view('front/main_layout',$this->data);		

		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'coulnt add category {$e->getMessage()}');
			redirect('frontend/onetomanyselfcategory');			
		}
	}
	function add_category_child($category){
		try {
			$category = $this->em->find('frontend\models\category',$category);
			if(!$category) throw new Exception("no category found", 1);
			$this->data['category']=$category;			
			if($this->input->post()){

				//feature details
				$child = new frontend\models\category;
				$child->setName($this->input->post('child')?$this->input->post('child'):NULL);
				$this->em->persist($child);

				//category details
				$child->setParent($category);


				$this->em->flush();
				$this->session->set_flashdata('success', 'category added successfully with child');
				redirect('frontend/onetomanyselfcategory');
			}
			$this->data['subview']=self::MODULE.'category/child/add';			
			$this->load->view('front/main_layout',$this->data);		
			
		} catch (Exception $e) {
			die($e->getMessage());
			$this->session->set_flashdata('error {$e->getMessage()}', 'coulnt add category');
			redirect('frontend/onetomanyselfcategory');			
		}
	}
	function add_category_with_childs(){
		try{
			if($this->input->post()){

				//eproduct details
				$category = new frontend\models\category;
				$category->setName($this->input->post('name')?$this->input->post('name'):NULL);
				
				//from child side
				// foreach ($this->input->post('childs') as $f) {
				// 	$child = new frontend\models\category;
				// 	$child->setName($f);
				// 	$child->setParent($category);
				// 	$this->em->persist($child);
				// }
				//from parent side
				foreach ($this->input->post('childs') as $f) {
					$child = new frontend\models\category;
					$child->setName($f);
					$child->setParent($category);
					$category->addChild($child);
					$this->em->persist($child);
				}

				$this->em->persist($category);
				$this->em->flush();

				$this->session->set_flashdata('success', 'category added successfully with childs');
				redirect('frontend/onetomanyselfcategory');
			}
			$this->data['subview']=self::MODULE.'category/add_with_child';			
			$this->load->view('front/main_layout',$this->data);		

		} catch (Exception $e) {
			$this->session->set_flashdata('error', "coulnt add category {$e->getMessage()}");
			redirect('frontend/onetomanyselfcategory');			
		}

	}
	// 1-8 self category:parent-childs

	// 8-1 uni client-country
	function manytooneclientcountry()
	{
		$this->data['clients']=$clients=$this->em->getRepository('frontend\models\client')->findAll();
		$this->data['subview']=self::MODULE.'client/list';			
		$this->load->view('front/main_layout',$this->data);		
	}
	function add_client(){
		try{
			$this->data['countries']=$countries=$this->em->getRepository('frontend\models\country')->findAll();
			if($this->input->post()){
				$client = new frontend\models\client;
				$client->setName($this->input->post('name')?$this->input->post('name'):NULL);
				if($this->input->post('country'))
					$country=$this->em->find('frontend\models\country',$this->input->post('country'));
				$client->setCountry($country);
				$this->em->persist($client);
				$this->em->flush();

				$this->session->set_flashdata('success', 'client added successfully');
				redirect('frontend/manytooneclientcountry');
			}
			$this->data['subview']=self::MODULE.'client/add';			
			$this->load->view('front/main_layout',$this->data);		

		} catch (Exception $e) {
			$this->session->set_flashdata('error', "coulnt add client {$e->getMessage()}");
			redirect('frontend/manytooneclientcountry');			
		}
	}
	// 8-1 uni client-country

	// 8-8 user:groups
	function manytomanyusergroups()
	{
		$this->data['users']=$users=$this->em->getRepository('frontend\models\user')->findAll();
		$this->data['subview']=self::MODULE.'user/list_groups';			
		$this->load->view('front/main_layout',$this->data);		
	}

	function assign_user_to_groups($user){
		try {
			
			$user = $this->em->find('frontend\models\user',$user);
			if(!$user) throw new Exception("no user found", 1);
			$this->data['user']=$user;			
			
			if($this->input->post()){
				$user->setUsername($this->input->post('name')?$this->input->post('name'):NULL);
				
				
				//method 1 how to use it 
				// if($user->getGroups())
				// 	$user->removeGroup($user->getGroups());
				
				//method 2
				$user->resetGroup();
				foreach ($this->input->post('groups') as $g) {
					$group = $this->em->find('frontend\models\group',$g);
					$user->addGroup($group);
				}
				$this->em->persist($user);
				$this->em->flush();
				$this->session->set_flashdata('success', 'user group updated successfully');
				redirect('frontend/manytomanyusergroups');
			}

			$dbgroups=$this->em->getRepository('frontend\models\group')->findAll();
			$groups=array();
			foreach ($dbgroups as $g) {
				$groups[$g->getId()]=$g->getName();
			}
			$this->data['groups']=$groups;

			$ugroups=$user->getGroups();
			$user_groups=array();
			foreach ($ugroups as $ug) {
				$user_groups[$ug->getId()]=$ug->getName();
			}
			$this->data['user_groups']=$user_groups;

			// show_pre($groups);
			// show_pre($user_groups);
			// die;
			$this->data['subview']=self::MODULE.'user/assign_groups';			
			$this->load->view('front/main_layout',$this->data);					
		} catch (Exception $e) {
			$this->session->set_flashdata('error',"{$e->getMessage()} coulnt update user group");
			redirect('frontend/manytomanyusergroups');			
		}
	}
	// 8-8 user:groups


	// 8-8 bi group-permission 
	function manytomanygroupspermissions()
	{
		$this->data['groups']=$groups=$this->em->getRepository('frontend\models\group')->findAll();
		$this->data['subview']=self::MODULE.'group/list';			
		$this->load->view('front/main_layout',$this->data);		
	}
	function add_group(){
		try{
			if($this->input->post()){
				$group = new frontend\models\group;
				$group->setName($this->input->post('name')?$this->input->post('name'):NULL);
				$this->em->persist($group);
				$this->em->flush();
				$this->session->set_flashdata('success', 'group added successfully');
				redirect('frontend/manytomanygroupspermissions');
			}
			$this->data['subview']=self::MODULE.'group/add';			
			$this->load->view('front/main_layout',$this->data);		
		} catch (Exception $e) {
			$this->session->set_flashdata('error', "coulnt add group {$e->getMessage()}");
			redirect('frontend/manytomanygroupspermissions');			
		}
	}
	function add_permission($group){
		try {
			
			$group = $this->em->find('frontend\models\group',$group);
			if(!$group) throw new Exception("no group found", 1);
			$this->data['group']=$group;			
			
			if($this->input->post()){
				$permission = new frontend\models\permission;
				$permission->setName($this->input->post('permission')?$this->input->post('permission'):NULL);
				$permission->addGroup($group);
				
				$this->em->persist($permission);
				
				//reset previous permision
				// $group->resetPermisson();
				$group->addPermission($permission);

				$this->em->persist($group);
				$this->em->flush();
				
				$this->session->set_flashdata('success', 'permision successfully under group');
				redirect('frontend/manytomanygroupspermissions');
			}
			$this->data['subview']=self::MODULE.'group/permission/add';			
			$this->load->view('front/main_layout',$this->data);		
			
		} catch (Exception $e) {
			die($e->getMessage());
			$this->session->set_flashdata('error'," {$e->getMessage()} coulnt add permision under group");
			redirect('frontend/manytomanygroupspermissions');			
		}
	}
	function assign_permisisons_to_group($group){
		try {
			
			$group = $this->em->find('frontend\models\group',$group);
			if(!$group) throw new Exception("no group found", 1);
			$this->data['group']=$group;			
			
			if($this->input->post()){
				$group->setName($this->input->post('name')?$this->input->post('name'):NULL);
				//reset permission
				$group->resetPermissons();
				foreach ($this->input->post('permissions') as $per) {
					$permission = $this->em->find('frontend\models\permission',$per);
					$group->addPermission($permission);
				}
				$this->em->persist($group);
				$this->em->flush();
				$this->session->set_flashdata('success', 'group permission updated successfully');
				redirect('frontend/manytomanygroupspermissions');
			}

			$dbpermissions=$this->em->getRepository('frontend\models\permission')->findAll();
			$permissions=array();
			foreach ($dbpermissions as $dbp) {
				$permissions[$dbp->getId()]=$dbp->getName();
			}
			$this->data['permissions']=$permissions;

			$gpermissions=$group->getPermissions();
			$group_permissions=array();
			foreach ($gpermissions as $gp) {
				$group_permissions[$gp->getId()]=$gp->getName();
			}
			$this->data['group_permissions']=$group_permissions;

			// show_pre($permissions);
			// show_pre($group_permissions);
			// die;

			$this->data['subview']=self::MODULE.'group/assign_groups';			
			$this->load->view('front/main_layout',$this->data);					
		} catch (Exception $e) {
			$this->session->set_flashdata('error',"{$e->getMessage()} coulnt update group permission");
			redirect('frontend/manytomanygroupspermissions');			
		}
	}
	// 8-8 group-permission bidirectional

	// 8-8 permission-group bidirectional
	function manytomanypermissionsgroups()
	{
		$this->data['permissions']=$permissions=$this->em->getRepository('frontend\models\permission')->findAll();
		$this->data['subview']=self::MODULE.'group/permission/list';			
		$this->load->view('front/main_layout',$this->data);		
	}
	// 8-8 permission-group bidirectional

}	

/* End of file sample.php */
/* Location: ./application/modules/sample/controllers/sample.php */