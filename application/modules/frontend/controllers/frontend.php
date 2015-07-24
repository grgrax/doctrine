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

	function onetoone()
	{
		$this->data['students']=$students=$this->em->getRepository('student\models\student')->findAll();
		// show_pre(var_dump($students));
		// Doctrine\Common\Util\Debug::dump($students);
		$this->data['subview']=self::MODULE.'student/list';			
		$this->load->view('front/main_layout',$this->data);		
	}

	function onetooneuni()
	{
		$this->data['products']=$products=$this->em->getRepository('frontend\models\product')->findAll();
		$this->data['subview']=self::MODULE.'product/list';			
		$this->load->view('front/main_layout',$this->data);		
	}

	function onetoonebi()
	{
		$this->data['carts']=$carts=$this->em->getRepository('frontend\models\cart')->findAll();
		$this->data['subview']=self::MODULE.'cart/list';			
		$this->load->view('front/main_layout',$this->data);		
	}

	function onetoonebicustomers()
	{
		$this->data['customers']=$customers=$this->em->getRepository('frontend\models\customer')->findAll();
		$this->data['subview']=self::MODULE.'cart/customer/list';			
		$this->load->view('front/main_layout',$this->data);		
	}

	function onetoonetbljoinuserpnos()
	{
		$this->data['users']=$users=$this->em->getRepository('frontend\models\user')->findAll();
		$this->data['subview']=self::MODULE.'user/list';			
		$this->load->view('front/main_layout',$this->data);		
	}

	function onetomanyfromeproduct()
	{
		$this->data['eproducts']=$products=$this->em->getRepository('frontend\models\eproduct')->findAll();
		$this->data['subview']=self::MODULE.'eproduct/feature/list';			
		$this->load->view('front/main_layout',$this->data);		
	}


	function onetomanyfromfeature()
	{
		$this->data['features']=$features=$this->em->getRepository('frontend\models\feature')->findAll();
		$this->data['subview']=self::MODULE.'eproduct/feature/all';			
		$this->load->view('front/main_layout',$this->data);		
	}

	function product($id){
		$this->data['shippings']=$shippings=$this->em->getRepository('frontend\models\shipping')->findAll();
		$this->data['product']=$product=$this->em->find('frontend\models\product',$id);	
		$this->data['subview']=self::MODULE.'product/edit';			
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

	// 1-8

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

	// 1-8

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
					$country=$this->em->find('student\models\country',$this->input->post('country'));
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
	// 1-8

	// 8-8
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

	// 8-8

}	

/* End of file sample.php */
/* Location: ./application/modules/sample/controllers/sample.php */