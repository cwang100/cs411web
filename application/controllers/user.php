<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('chat_model');
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
			$data['title'] = $this->session->userdata('user_name').", welcome! | IlliniBeauty";
			$data['recomm'] = $this->user_model->get_recom($this->session->userdata('user_id'));
		}
		else
		{
			$data['islogin'] = 0;
			$data['login_form'] = $this->load->view('login_view.php','',true);
			$data['register'] = $this->load->view('registration_view.php','',true);
			$data['title']= 'Home | IlliniBeauty';
		}

		$data['baseurl'] = base_url();
		
		$this->load->view('header_view',$data);

		$this->load->view("welcome_view.php", $data);

		// $this->load->view('footer_view',$data);
	}
	public function userhome()
	{
		if(!$this->is_logged_in())
		{
			$this->index();
		}
		$data['islogin'] = 1;
		$data['title'] = $this->session->userdata('user_name')."'s homepage | IlliniBeauty";
		$data['user'] = $this->session->userdata('user_name');

		$data['orderlist'] = $this->user_model->get_order_list($this->session->userdata('user_id'));
		$data['postlist'] = $this->user_model->get_post_list($this->session->userdata('user_id'));
		$data['user_list'] = $this->user_model->get_user_list($this->session->userdata('user_id'));

		$data['msg_list'] = $this->user_model->get_msg_list($this->session->userdata('user_id'));

		$this->load->view('header_view',$data);
		$this->load->view("userhome_view.php", $data);
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
		$data['title']= 'Thank | IlliniBeauty';
		$data['islogin'] = 0;
		$data['login_form'] = $this->load->view('login_view.php','',true);
		$this->load->view('header_view',$data);
		$this->load->view('thank_view.php', $data);
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
				$data['user_exist'] = 1;
				$data['islogin'] = 0;
				$data['login_form'] = $this->load->view('login_view.php','',true);
				$data['register'] = $this->load->view('registration_view.php','',true);
				$data['title']= 'Home | IlliniBeauty';
				
				$this->load->view('header_view',$data);
				$this->load->view("welcome_view.php", $data);
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
		$this->chat_model->kill_session();
		$this->user_model->offline($this->session->userdata('user_id'));
		$this->session->unset_userdata($newdata );
		$this->session->sess_destroy();
		$this->index();
	}

	public function sendmsg()
	{
		$msg = $_POST['msg'];
		$recverid = $_POST['recver'];
		if($recverid != $this->session->userdata('user_id'))
		{
			$this->user_model->add_msg($msg, $recverid);
		}
		else
		{
			echo '0';
		}
	}
	public function sendmsg2()
	{
		$msg = $_POST['msg'];
		$recverid = $_POST['recver'];
		$this->user_model->add_msg2($msg, $recverid);
		$this->userhome();
	}
	public function checkmsg()
	{
		$this->user_model->check_msg($this->session->userdata('user_id'));
	}
	public function set_msg_read()
	{
		$this->user_model->set_msg_read($this->session->userdata('user_id'));
	}
}
?>