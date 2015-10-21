<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Post_model extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
    }
    public function add_item($item_info)
    {
        $this->db->insert('Item', $item_info);
        return mysql_insert_id();
    }
    public function update_sell($item_id, $user_id)
    {
        $this->db->insert('Sell', array('itemid' => $item_id, 'posterid' => $user_id));
    }
    public function add_top($item_id, $item_style, $item_size)
    {
        $array = array(
            'id' => $item_id,
            'style' => $item_style,
            'size' => $item_size
            );
        $this->db->insert('Top', $array);
    }
	function login($username,$password)
    {
		$this->db->where("username",$username);
        $this->db->where("password",$password);
            
        $query=$this->db->get("User");
        if($query->num_rows()>0)
        {
         	foreach($query->result() as $rows)
            {
            	//add all data to session
                $newdata = array(
                	   	'user_id' 		=> $rows->id,
                    	'user_name' 	=> $rows->username,
		                'user_email'    => $rows->email,
	                    'logged_in' 	=> TRUE,
                   );
			}
            	$this->session->set_userdata($newdata);
                return true;            
		}
		return false;
    }
	public function add_user()
	{
        if($this->user_exists($this->input->post('user_name')))
        {
            return false;
        }

		$data=array(
			'username'=>$this->input->post('user_name'),
			'email'=>$this->input->post('email_address'),
			'password'=>md5($this->input->post('password'))
			);
		$this->db->insert('User',$data);
        return true;
	}
    public function user_exists($username){
        $this->db->select('username');
        $this->db->where('username',$username);
        $query = $this->db->get('User');

        if ($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function insert_file($filename, $title)
    {
        $data = array(
            'filename'      => $filename,
            'title'         => $title
        );
        $this->db->insert('files', $data);
        return $this->db->insert_id();
    }

}
?>