<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contact extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		// $this->load->model('type_model');
	}
	public function is_logged_in()
    {
        // $user = $this->session->userdata('user_name');
        // return isset($user);
        return ($this->session->userdata('user_name')!="");
    }
    public function index()
    {
    	if($this->is_logged_in())
		{
			$data['islogin'] = 1;
			$data['user'] = $this->session->userdata('user_name');
		}
		else
		{
			$data['islogin'] = 0;
			$data['login_form'] = $this->load->view('login_view.php','',true);
		}
		$data['title'] = "Contact | IlliniBeauty";

		$this->load->view("header_view.php",$data);
		$this->load->view("contact.php");
    }
}
?>