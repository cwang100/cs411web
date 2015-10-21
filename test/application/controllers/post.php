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
    public function type_check($str)
    {
        // if($str == 'none')
    }
    public function postitem()
    {
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'name',
                'label' => 'item name',
                'rules' => 'required'
                ),
            array(
                'field' => 'count',
                'label' => 'item count',
                'rules' => 'required'
                ),
            array(
                'field' => 'price',
                'label' => 'item price',
                'rules' => 'required'
                ),
            array(
                'field' => 'gender',
                'label' => 'item gender',
                'rules' => ''
                ),
            array(
                'field' => 'type',
                'label' => 'item type',
                'rules' => ''
                ),
            array(
                'field' => 'material',
                'label' => 'item material',
                'rules' => ''
                ),
            array(
                'field' => 'style',
                'label' => 'item style',
                'rules' => ''
                ),
            array(
                'field' => 'size',
                'label' => 'item size',
                'rules' => ''
                ),
            array(
                'field' => 'detail',
                'label' => 'item detail',
                'rules' => ''
                ),
            );
        $this->form_validation->set_rules($config);

    	if($this->is_logged_in())
    	{
            if($this->form_validation->run() == FALSE)
            {
                $this->index();
            }
            else
            {
                $item_name=$this->input->post('name');
                $item_type=$this->input->post('type');
                $item_material=$this->input->post('material');
                $item_gender=$this->input->post('gender');
                $item_count=$this->input->post('count');
                $item_detail=$this->input->post('detail');

                $item_type=$this->input->post('type');
                $item_style=$this->input->post('style');
                $item_size=$this->input->post('size');
                $item_price=$this->input->post('price');

                $item_url=$this->input->post('url');

                $item_owner=$this->session->userdata('user_id');
                $item_sold=FALSE;

                $item_info = array(
                    'name' => $item_name,
                    'material' => $item_material,
                    'gender' => $item_gender,
                    'count' => $item_count,
                    'detail' => $item_detail,

                    'ownerid' => $item_owner,
                    'sold' => $item_sold,
                    'img' => $item_url,

                    'type' => $item_type,
                    'style' => $item_style,
                    'size' => $item_size,
                    'price' => $item_price
                    );

                $item_id = $this->post_model->add_item($item_info);
                $this->post_model->update_sell($item_id, $item_owner);
                
                redirect('/detail?id='.$item_id);
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
}
?>