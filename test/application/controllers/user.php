<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
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
			$string = $this->session->userdata('user_name').$this->load->view('logout_view.php','',true);
			$data['islogin'] = $string;
			$data['register'] = "";
			$data['title']= $this->session->userdata('user_name').", welcome!";
		}
		else
		{
			$data['islogin'] = $this->load->view('login_view.php','',true);
			$data['register'] = $this->load->view('registration_view.php','',true);
			$data['title']= 'Home';
		}

		
		$this->load->view('header_view',$data);

		$this->load->view("welcome_view.php", $data);

		// $this->load->view('footer_view',$data);
	}
	public function login()
	{
		$username=$this->input->post('username');
		$password=md5($this->input->post('pass'));

		$result=$this->user_model->login($username,$password);
		$this->index();
	}
	public function thank()
	{
		$data['title']= 'Thank';
		$data['islogin'] = $this->load->view('login_view.php','',true);
		$this->load->view('header_view',$data);
		$this->load->view('thank_view.php', $data);
		// $this->load->view('footer_view',$data);
	}
	public function registration()
	{
		// $this->load->view('registration_view.php');

		$this->load->library('form_validation');
		// field name, error message, validation rules
		$this->form_validation->set_rules('user_name', 'User Name', 'trim|required|min_length[4]|xss_clean');
		$this->form_validation->set_rules('email_address', 'Your Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
		$this->form_validation->set_rules('con_password', 'Password Confirmation', 'trim|required|matches[password]');

		if($this->form_validation->run() == FALSE)
		{
			$this->index();
		}
		else
		{
			if($this->user_model->add_user())
			{
				$this->thank();
			}
			else
			{
				$this->index();
			}
		}
	}
	public function logout()
	{
		$newdata = array(
		'user_id'   =>'',
		'user_name'  =>'',
		'user_email'     => '',
		'logged_in' => FALSE,
		);
		$this->session->unset_userdata($newdata );
		$this->session->sess_destroy();
		$this->index();
	}
}
?>