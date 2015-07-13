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
				$student->setName($this->input->post('name'));
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
}

/* End of file sample.php */
/* Location: ./application/modules/sample/controllers/sample.php */