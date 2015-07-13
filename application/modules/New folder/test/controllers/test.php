<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Make sure to load the Facebook SDK for PHP via composer or manually

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
// add other classes you plan to use, e.g.:
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;


class test extends Frontend_Controller {

	public $data;
	const MODULE='test/';

	function __construct()
	{
		parent::__construct();
		// parse_str( $_SERVER['QUERY_STRING'], $_REQUEST );
		// $this->load->library(array('form_validation','session','breadcrumb','facebook'));
		// $this->load->library('facebook');
		$this->load->library(array('form_validation','breadcrumb','session'));
		$this->data['link']=base_url().self::MODULE;
	}

	public function index()
	{
		$this->load->model('user/user_m');
		$users=$this->user_m->read_rows_by(array('group_id'=>3,'status'=>1));
		show_pre($users);
		echo 'null: ';
		$c=get_cms_config();
		echo $c?$c:'no';
		echo '<hr/>not null, not set: ';
		$c=get_cms_config('enabe_jq_validations');
		echo $c?$c:'no';
		echo '<hr/>set: ';
		$c=get_cms_config('enabe_jq_validation');
		echo $c?$c:'no';
		echo '<hr/>fb_key: ';
		$c=get_cms_config('fb_key');
		echo $c?$c:'no';
		die;
	}


	public function manage()
	{
		$this->data['subview']=self::MODULE.'manage';
		$this->load->view('front/main_layout',$this->data);		
	}

	public function admin()
	{
		$this->data['subview']=self::MODULE.'admin';
		$this->load->view('front/main_layout',$this->data);		
	}

	
	public function mail() {
		try {
			$from['from_name'] = 'Our Library';
			$from['from_email'] =  'basant@gmail.com';
			$to['to_name'] = 'ramesh';
			$to['to_email'] = 'raxizel@gmail.com';					
			$subject = "Our library Account Confirmation";
			$message= "We're ready to activate your account. All we need to do is make sure this is your email address.";	
			$message.="<br/>";
			$key=md5(date('Y-m-d H:m:s'));
			$user_id=$this->session->userdata('lastuser_id');
			$user_id=61;
			if(!$user_id) 
				throw new Exception("no lastuser_id", 1);				
			$url=base_url("test/activate/$key/$user_id");
			$style="border-radius:3px;background:#3aa54c;color:#fff;display:block;font-weight:700;font-size:16px;line-height:1.25em;margin:24px auto 24px;padding:10px 18px;text-decoration:none;width:180px;text-align:center";
		// $message.=anchor($url, 'Click here to confirm', $style);
			$message.=anchor($url, 'Click here to confirm', '');
			$res = App\Mailer::sendMail($from, $to, $subject, $message);	
			show_pre($res);
			if($res==1){
				echo "insert into db";
			}
			else
				echo "fail";
			
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			echo $e->getMessage();			
		}
	}

	public function php_mail(){
		try {
			$msg = "First line of text\nSecond line of text";
			$msg = wordwrap($msg,70);
			mail("raxizel@gmail.com","My subject",$msg);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	public function ci_mail() {
		try {

			$configs = array(
				'protocol'=>'smtp',
				'smtp_host'=>'smtp.gmail.com',
				'smtp_port'=>465,
				'smtp_user'=>'celosiadesigns4u@gmail.com',
				'smtp_pass'=>"setedeep",
				'smtp_crypto' => 'ssl',
				);
			$this->load->library("email", $configs);
			$this->email->set_newline("\r\n");
			$this->email->to("raxizel@gmail.com");
			$this->email->from("celosiadesigns4u@gmail.com", "rajat singh");
			$this->email->subject("This is bloody amazing.");
			$this->email->message("Body of the Message");
			if($this->email->send())
			{
				echo "Done!";   
			}
			else
			{
				echo $this->email->print_debugger();    
			}
			die;

			$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => $this->config->item('smtp_host'),
				'smtp_port' => $this->config->item('smtp_port'),
				'smtp_user' => $this->config->item('smtp_user'), 
				'smtp_pass' => $this->config->item('smtp_pass'), 
				'mailtype' => 'html',
				'charset' => 'iso-8859-1',
				'wordwrap' => TRUE
				);
			show_pre($config);
			$this->load->library('email', $config);
			$this->email->from('celosiadesigns4u@gmail.com','Our Library'); 
			$this->email->to('raxizel@gmail.com');
			$this->email->subject('Our library Account Confirmation');
			$message = '';
			$message= "We're ready to activate your account. All we need to do is make sure this is your email address.";	
			$message.="<br/>";
			$key=md5(date('Y-m-d H:m:s'));
			// $user_id=$this->session->userdata('lastuser_id');
			$user_id=61;
			if(!$user_id) 
				throw new Exception("no lastuser_id", 1);				
			$url=base_url("test/activate/$key/$user_id");
			$message.=anchor($url, 'Click here to confirm', '');			
			$this->email->message($message);
			if($this->email->send())
			{
				echo 'Email sent.';
			}
			else
			{
				show_error($this->email->print_debugger());
			}
			die;
			$from['from_name'] = 'Our Library';
			$from['from_email'] =  'basant@gmail.com';
			$to['to_name'] = 'ramesh';
			$to['to_email'] = 'raxizel@gmail.com';					
			$subject = "Our library Account Confirmation";
			$message= "We're ready to activate your account. All we need to do is make sure this is your email address.";	
			$message.="<br/>";
			$key=md5(date('Y-m-d H:m:s'));
			$user_id=$this->session->userdata('lastuser_id');
			$user_id=61;
			if(!$user_id) 
				throw new Exception("no lastuser_id", 1);				
			$url=base_url("test/activate/$key/$user_id");
			$style="border-radius:3px;background:#3aa54c;color:#fff;display:block;font-weight:700;font-size:16px;line-height:1.25em;margin:24px auto 24px;padding:10px 18px;text-decoration:none;width:180px;text-align:center";
		// $message.=anchor($url, 'Click here to confirm', $style);
			$message.=anchor($url, 'Click here to confirm', '');
			$res = App\Mailer::sendMail($from, $to, $subject, $message);	
			show_pre($res);
			if($res==1){
				//insert into db
			}

		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			echo $e->getMessage();			
		}
	}


	public function ci_mail_lib() {
		try {
			$configs = array(
				'protocol'=>'mail',
				'smtp_host'=>'mail.ourlibrary.com.au',
				'smtp_port'=>465,
				'smtp_user'=>'info@ourlibrary.com.au',
				'smtp_pass'=>"ourlib@123",
				'smtp_crypto' => 'ssl',
				);
			$this->load->library("email", $configs);
			$this->email->set_newline("\r\n");
			$this->email->to("raxizel@gmail.com");
			$this->email->from("info@ourlibrary.com.au", "Our Library");
			$this->email->subject("This is bloody amazing.");
			$this->email->message("Body of the Message");
			if($this->email->send())
			{
				echo "Done!";   
			}
			else
			{
				echo $this->email->print_debugger();    
			}
			die;
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			echo $e->getMessage();			
		}
	}
	
	public function activate($token=null,$user_id=null)
	{
		try {
			if(!$token)
				throw new Exception("no token", 1);
			if(!$user_id)
				throw new Exception("no user_id", 1);
			$this->load->model('user/user_m');
			$param['key']='verification_code';
			$param['value']=$token;
			$user=$this->user_m->read_row_by($param);
			if(!$user)
				throw new Exception("no user", 1);
			if($user['id']!=$user_id)
				throw new Exception("invalid user for the token", 1);
			if($user['status']==user_m::ACTIVE)
				throw new Exception("already activated", 1);
			$data=array(
				'status'=>user_m::ACTIVE,
				);
			$this->user_m->update_row($user['id'],$data);
			$this->session->set_flashdata('success', 's');
			// show_pre($user);
			redirect('donor/dashboard');
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			echo $e->getMessage();
		}
	}

	public function multifileupload()
	{
		try {
			if($this->input->post()){

				$config = array(
					'upload_path'   => 'uploads/campaign/',
					'allowed_types' => 'jpg|gif|png',
					'overwrite'     => 1,                       
					);
				$this->load->library('upload', $config);
				foreach ($_FILES['photos']['name'] as $key => $value) {
					$this->upload->initialize($config);
					if(!$this->upload->do_my_upload('photos', $key)){
						$this->data['error'][]=$this->upload->display_errors();
					}
					else{
						$this->data['success'][] = array('upload_data' => $this->upload->data());
					}
				}
				show_pre($this->data);
				die;

				$config = array(
					'upload_path'   => 'uploads/campaign/',
					'allowed_types' => 'jpg|gif|png',
					'overwrite'     => 1,                       
					);
				$this->load->library('upload', $config);
				if($this->upload->do_multi_upload("photos")) {
					$this->data['success'] = array('upload_data' => $this->upload->data());
				}
				else{
					$this->data['error']=$this->upload->display_errors();
				}
				show_pre($this->data);
			}
			$this->data['subview']=self::MODULE.'personal_details';
			$this->load->view('front/main_layout',$this->data);		
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			die($e->getMessage());
		}
	}

	public function jquery_validation()
	{
		$this->data['subview']=self::MODULE.'jquery_validation';
		$this->load->view('front/main_layout',$this->data);		
	}

	public function sign_up()
	{
		$this->data['user']=null;
		$this->data['subview']=self::MODULE.'sign_up';
		$this->load->view('front/main_layout',$this->data);		
	}

	public function fb_login()
	{
		$user = $this->facebook->getUser();
		echo $user;
		// $this->data['user'] = $this->facebook->api('/me');
		// show_pre($this->data['user']);
		// die;

		$this->data['user']=null;
		if(!$user){
			$this->data['url'] = $this->facebook->getLoginUrl(array(
				'redirect_uri' => 'http://localhost/cel/2015/may/projects/donatenow/test/fb_profile', 
				'scope' => array("email") 
				));
			// redirect($this->data['url']);
		} else {
			$this->data['user'] = $this->facebook->api('/me');
			show_pre($this->data['user']);
			die;
			$this->data['url'] = 'test/fb_profile';
			show_pre($this);
		}
		redirect($this->data['url']);
	}

	public function fb_profile(){

		Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYPEER] = false;
		Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYHOST] = 2;

		// echo $accessToken = $this->facebook->getAccessToken();
		// $this->facebook->setAccessToken($accessToken);
		$user = $this->facebook->getUser();
		if($user){
			echo "fb user logged in";
		}
		$this->data['user'] = $this->facebook->api('/me');
		$this->data['subview']=self::MODULE.'profile';
		$this->load->view('front/main_layout',$this->data);
		// $this->session->session_destroy();
	}

	public function p(){
		if($session) {
			try {
				$user_profile = (new FacebookRequest(
					$session, 'GET', '/me'
					))->execute()->getGraphObject(GraphUser::className());
				echo "Name: " . $user_profile->getName();
			} catch(FacebookRequestException $e) {
				echo "Exception occured, code: " . $e->getCode();
				echo " with message: " . $e->getMessage();
			}   
		}	}

		public function fb_logout()
		{
			die("log out");
			$this->load->library('facebook');
        // Logs off session from website
			$this->facebook->destroySession();
        // Make sure you destory website session as well.
			redirect('welcome/login');

		}


		public function signup(){
			$this->data['subview']=self::MODULE.'sign_up';
			$this->load->view('front/main_layout',$this->data);
		}

		public function user(){
			$user = $this->facebook->getUser();
			if(!$user){
            // Generate a login url
				$data['login_url'] = $this->facebook->getLoginUrl(array(
        		// 'redirect_uri' => site_url('test/logout'), 
					'redirect_uri' => 'http://ivmfilms.com', 
                'scope' => array("email") // permissions here
                ));
				redirect($data['login_url']);
			} else {
            // Get user's data and print it
				$user = $this->facebook->api('/me');
				$this->data['user'] = $user;
				$this->data['subview']=self::MODULE.'sign_up';
				$this->load->view('front/main_layout',$this->data);
				show_pre($user);
			}
		}

		public function fb_lib(){
		$this->load->library('facebook'); // Automatically picks appId and secret from config
        // OR
        // You can pass different one like this
        //$this->load->library('facebook', array(
        //    'appId' => 'APP_ID',
        //    'secret' => 'SECRET',
        //    ));

		$user = $this->facebook->getUser();
 // If user is not yet authenticated, the id will be zero
		if($user == 0){
            // Generate a login url
			$data['login_url'] = $this->facebook->getLoginUrl(array(
        		// 'redirect_uri' => site_url('test/logout'), 
				'redirect_uri' => 'http://ivmfilms.com', 
                'scope' => array("email") // permissions here
                ));
			redirect($data['login_url']);
		} else {
            // Get user's data and print it
			$user = $this->facebook->api('/me');
			$this->data['subview']=self::MODULE.'index';
			$this->load->view('front/main_layout',$this->data);		
			
			print_r($user);
		}
		die;

		if ($user) {
			try {
				$data['user_profile'] = $this->facebook->api('/me');
			} catch (FacebookApiException $e) {
				$user = null;
			}
		}else {
			$this->facebook->destroySession();
		}

		if ($user) {

            // $data['logout_url'] = site_url('http://localhost/crowd/test/login'); // Logs off application
            // OR 
            // Logs off FB!
			$data['logout_url'] = $this->facebook->getLogoutUrl();

		} else {
			$data['login_url'] = $this->facebook->getLoginUrl(array(
        		// 'redirect_uri' => site_url('http://localhost/crowd/test/logout'), 
                'scope' => array("email") // permissions here
                ));
			redirect($data['login_url']);
		}
		show_pre($data);
	}

	public function fb()
	{
		FacebookSession::setDefaultApplication('415752498606532', '056f3da72d450f80fe1b24f8e0b4efed');
		$helper = new FacebookRedirectLoginHelper('http://localhost/crowd/test');
		$loginUrl = $helper->getLoginUrl();
		try {
			// $session = $helper->getSessionFromRedirect();
			// $session = new FacebookSession('AQAKwHUV_D0JrhFJ79TxvDTTnjUeJa5WZ2sBsbAhz2MsbPvfOVxj1PReyTlhFt5kBUSmOQtxOIReSVJc3cPo2n_5Ao8u0w9LAQbeyiEkVZ5');
			$session = new FacebookSession('AQAKwHUV_D0JrhFJ79TxvDTTnjUeJa5WZ2sBsbAhz2MsbPvfOVxj1PReyTlhFt5kBUSmOQtxOIReSVJc3cPo2n_5Ao8u0w9LAQbeyiEkVZ5');
		} catch(FacebookRequestException $ex) {
			die($ex);
		// When Facebook returns an error
		} catch(\Exception $ex) {
			die($ex);
		// When validation fails or other local issues
		}
		if ($session) {
			show_pre($session);
			$request = new FacebookRequest($session, 'GET', '/me');
			$response = $request->execute();
			$graphObject = $response->getGraphObject();
			show_pre($request);
			show_pre($response);
			show_pre($graphObject);
			die("yes");
		// Logged in
		}else
		die("no");
		// Use the login url on a link or button to 
		// redirect to Facebook for authentication
	}

	function sess_destroy(){
		$this->session->sess_destroy();
	}

	function new_fb(){
// init app with app id (APPID) and secret (SECRET)
		// FacebookSession::setDefaultApplication('APPID','SECRET');
		// FacebookSession::setDefaultApplication('415752498606532', '056f3da72d450f80fe1b24f8e0b4efed');
		FacebookSession::setDefaultApplication($this->config->item('APPID'), $this->config->item('SECRET'));

// login helper with redirect_uri
		$helper = new FacebookRedirectLoginHelper( 'http://localhost/cel/2015/may/projects/donatenow/test/new_fb' );
		// $helper = new FacebookRedirectLoginHelper( 'http://localhost/phpmyadmin' );

		try {
			$session = $helper->getSessionFromRedirect();
		} catch( FacebookRequestException $ex ) {
  // When Facebook returns an error
		} catch( Exception $ex ) {
  // When validation fails or other local issues
		}

// see if we have a session
		if ( isset( $session ) ) {
  // graph api request for user data
			$request = new FacebookRequest( $session, 'GET', '/me' );
			$response = $request->execute();
  // get response
			$fb_user = $response->getGraphObject()->asArray();

  // print data
			$this->session->set_userdata('fb_user',$fb_user);
			show_pre(get_session('fb_user'));
			//get photos
			$user_photos = (new FacebookRequest(
				$session, 'GET', '/me/photos'
				))->execute()->getGraphObject();
			$user_photos = $user_photos->asArray();
			echo count($user_photos);
			print_r($user_photos);
			//$pic = $user_photos["data"][0]->{"source"};
          	// echo "<img src='$pic' />";die;
			die;
			redirect('test/new_fb_profile');
		} else {
  // show login url
			echo '<a href="' . $helper->getLoginUrl() . '">Login</a>';
		}
	}

	function new_fb_profile(){
		if($fb_user=get_session('fb_user')){
			show_pre($fb_user);
		}
		else{
			echo "redirect to new_fb";
			// redirect('test/new_fb');
		}
	}

	function db($n){
		if($n=='9806677215'){
			// echo $this->db->hostname;
			// echo $this->db->username;
			// echo $this->db->password;
			// echo $this->db->database;
			die('ok');			
		}
	}

	function php_mail_html(){
		$to = "raxizel@gmail.com, rameshgurung2008@gamil.com";
		$subject = "HTML email";
		$message = "
		<html>
		<head>
			<title>HTML email</title>
		</head>
		<body>
			<p>This email contains HTML Tags!</p>
			<table>
				<tr>
					<th>Firstname</th>
					<th>Lastname</th>
				</tr>
				<tr>
					<td>John</td>
					<td>Doe</td>
				</tr>
			</table>
		</body>
		</html>
		";
// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
// More headers
		$headers .= 'From: <webmaster@ourlibrary.com>' . "\r\n";
				// $headers .= 'Cc: rameshgurung2008@gmail.com' . "\r\n";
		echo mail($to,$subject,$message,$headers)?'send':'fail';

	}

	public function swift_mailer(){
		try {
		//send verfication code to his/her email
			$from['from_name'] = 'Our Library';
			$from['from_email'] =  'rameshgurung2008@gmail.com';
			$to['to_name'] = 'ramesh';
			$to['to_email'] = 'raxizel@gmail.com';					
			$subject = "Our library Account Confirmation";
			$message= "We're ready to activate your account. All we need to do is make sure this is your email address.";	
			$message.="<br/>";
			$key=md5(date('Y-m-d H:m:s'));
			$url=base_url("test/activate/$key");
			$style="border-radius:3px;background:#3aa54c;color:#fff;display:block;font-weight:700;font-size:16px;line-height:1.25em;margin:24px auto 24px;padding:10px 18px;text-decoration:none;width:180px;text-align:center";
					// $message.=anchor($url, 'Click here to confirm', $style);
			$message.=anchor($url, 'Click here to confirm', '');
			$res = App\Mailer::sendMail($from, $to, $subject, $message);	
			show_pre($res);
			if($res==1){
			}
			
		} catch (Exception $e) {
			die($e->getMessage());			
		}
	}
}


/* End of file sample.php */
/* Location: ./application/modules/sample/controllers/sample.php */




