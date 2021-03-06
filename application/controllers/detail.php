<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Detail extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('detail_model');
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
            $data['user'] = "";
        }
        
        $item_id = $_GET['id'];
        $data['item_detail'] = $this->detail_model->get_item_detail($item_id);
        $data['itemlist'] = $this->detail_model->get_item_list($data['item_detail']->ownerid, $item_id);
        $data['userid'] = $this->session->userdata('user_id');
        $data['seller_status'] = $this->detail_model->get_seller_status($data['item_detail']->ownerid);
        
        if($data['item_detail'])
        {
            $data['title'] = $data['item_detail']->name." | IlliniBeauty";
        }
        else
        {
            $data['title'] = "Item removed | IlliniBeauty";
        }
		$this->load->view("header_view.php",$data);
		$this->load->view("detail_view.php");
    }
    public function errorpage()
    {
        $data['islogin'] = $this->load->view('login_view.php','',true);
        $this->load->view("header_view.php",$data);
        $this->load->view("error_view.php");
    }
    public function buy()
    {
        if($this->is_logged_in())
        {
            $data['islogin'] = 1;
            $data['user'] = $this->session->userdata('user_name');

            $item_id = $_GET['id'];
            $user_id = $this->session->userdata('user_id');
            $data['item_detail'] = $this->detail_model->get_item_detail($item_id);
            $data['buy_success'] = $this->detail_model->buy_item($item_id, $user_id);
            $this->detail_model->send_buy_msg($data['item_detail']);
        }
        else
        {
            $data['islogin'] = 0;
            $data['login_form'] = $this->load->view('login_view.php','',true);
            $data['buy_success'] = -1;
        }

        $this->load->view("header_view.php",$data);
        $this->load->view("buy_view.php",$data);
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

            $item_url=$this->input->post('url');

            $item_owner=$this->session->userdata('user_name');
            $item_sold=FALSE;

            $item_info = array(
                'name' => $item_name,
                'material' => $item_material,
                'gender' => $item_gender,
                'count' => $item_count,
                'detail' => $item_detail,

                'owner' => $item_owner,
                'sold' => $item_sold,
                'img' => $item_url
                );

            $item_style=$this->input->post('style');
            $item_size=$this->input->post('size');

            $item_id = $this->post_model->add_item($item_info);
    		if($item_id != 0)
            {
                switch ($item_type) {
                    case 'top':
                        $this->post_model->add_top($item_id, $item_style, $item_size);
                        redirect('/type/top');
                        break;
                    case 'bottom':
                        $this->post_model->add_bottom($item_id, $item_style, $item_size);
                        break;
                    case 'shoes':
                        $this->post_model->add_shoes($item_id, $item_style, $item_size);
                        break;
                }

            }
            else
            {
                echo "error";
            }
    	}
        else
        {
            $this->errorpage();
        }
    }

    public function up_img()
    {
        $action = $_GET['act'];
        if($action=='delimg'){
            $filename = $_POST['imagename'];
            if(!empty($filename)){
                unlink(FCPATH."upload/".$filename);
                echo '1';
            }else{
                echo '0';
            }
        }else{
            $picname = $_FILES['mypic']['name'];
            $picsize = $_FILES['mypic']['size'];
            if ($picname != "") {
                if ($picsize > 1024000) {
                    echo 'Image size cannot exceed 1MB';
                    exit;
                }
                // $type = strstr($picname, '.');
                $type = pathinfo($picname, PATHINFO_EXTENSION);
                if ($type != "gif" && $type != "jpg" && $type != "png") {
                    echo 'Image type wrong!'.$type;
                    exit;
                }
                $rand = rand(100, 999);
                $pics = date("YmdHis") . $rand . ".".$type;
                $pic_path = FCPATH."upload/". $pics;
                move_uploaded_file($_FILES['mypic']['tmp_name'], $pic_path);
            }
            $size = round($picsize/1024,2);
            $arr = array(
                'name'=>$picname,
                'pic'=>$pics,
                'size'=>$size
            );
            echo json_encode($arr);
        }
    }
    public function removed()
    {
        if($this->is_logged_in())
        {
            $data['islogin'] = 1;
            $data['user'] = $this->session->userdata('user_name');

            $item_id = $_GET['id'];
            $this->detail_model->remove_item($item_id);
        }
        else
        {
            $data['islogin'] = 0;
            $data['login_form'] = $this->load->view('login_view.php','',true);
        }
        $data['title'] = "Item removed | IlliniBeauty";

        $this->load->view("header_view.php",$data);
        $this->load->view("removed_view.php");
    }
}
?>