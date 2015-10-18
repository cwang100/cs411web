<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Type extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('type_model');
	}
	public function is_logged_in()
    {
        // $user = $this->session->userdata('user_name');
        // return isset($user);
        return ($this->session->userdata('user_name')!="");
    }
	public function top()
	{
		$string = $this->type_model->getTop();
		$data['itemlist'] = $string;
		
		if($this->is_logged_in())
		{
			$string = $this->session->userdata('user_name').$this->load->view('logout_view.php','',true);
			$data['islogin'] = $string;
		}
		else
		{
			$data['islogin'] = $this->load->view('login_view.php','',true);
		}
		$this->load->view("header_view.php",$data);
		$this->load->view("type/top.php");
	}
	public function bottom()
	{
		if($this->is_logged_in())
		{
			$string = $this->session->userdata('user_name').$this->load->view('logout_view.php','',true);
			$data['islogin'] = $string;
		}
		else
		{
			$data['islogin'] = $this->load->view('login_view.php','',true);
		}
		$this->load->view("header_view.php",$data);
		$this->load->view("type/bottom.php");
	}
	public function shoes()
	{
		if($this->is_logged_in())
		{
			$string = $this->session->userdata('user_name').$this->load->view('logout_view.php','',true);
			$data['islogin'] = $string;
		}
		else
		{
			$data['islogin'] = $this->load->view('login_view.php','',true);
		}
		$this->load->view("header_view.php",$data);
		$this->load->view("type/shoes.php");
	}
}
?>