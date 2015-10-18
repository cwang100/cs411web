<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Post extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('post_model');
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
		}
		else
		{
			$data['islogin'] = $this->load->view('login_view.php','',true);
		}
		$this->load->view("header_view.php",$data);
		$this->load->view("post_view.php");
    }
    public function errorpage()
    {
        $data['islogin'] = $this->load->view('login_view.php','',true);
        $this->load->view("header_view.php",$data);
        $this->load->view("error_view.php");
    }
    public function postitem()
    {
    	if($this->is_logged_in())
    	{
    		$item_name=$this->input->post('name');
            $item_type=$this->input->post('type');
            $item_material=$this->input->post('material');
            $item_gender=$this->input->post('gender');
            $item_count=$this->input->post('count');
            $item_detail=$this->input->post('detail');

            $item_owner=$this->session->userdata('user_name');
            $item_sold=FALSE;

            $item_info = array(
                'name' => $item_name,
                'material' => $item_material,
                'gender' => $item_gender,
                'count' => $item_count,
                'detail' => $item_detail,

                'owner' => $item_owner,
                'sold' => $item_sold
                );

    		if($this->post_model->add_item($item_info))
            {
                $this->index();
            }
            else
            {

            }
    	}
        else
        {
            $this->errorpage();
        }
    }
}
?>