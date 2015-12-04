<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
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
                $this->db->where('id',$newdata['user_id']);
                $this->db->update('User', array('online' => 1));
                return true;
		}
		return false;
    }
    public function offline($user_id)
    {
        $this->db->where('id',$user_id);
        $this->db->update('User', array('online' => 0));
        // session_destroy();
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
    public function get_order_list($user_id)
    {
        $this->db->select('Item.id AS id, Item.name AS name, Item.img AS img');
        $this->db->from('Buy');
        $this->db->where('Buy.buyerid', $user_id);
        $this->db->join('Item', 'Buy.itemid = Item.id');
        $query = $this->db->get();
        return $query->result();
    }
    public function get_post_list($user_id)
    {
        $this->db->select('Item.id AS id, Item.name AS name, Item.img AS img');
        $this->db->from('Sell');
        $this->db->where('Sell.posterid', $user_id);
        $this->db->join('Item', 'Sell.itemid = Item.id');
        $query = $this->db->get();
        return $query->result();
    }
    public function get_max_buydate($user_id)
    {
        $this->db->select_max('buydate');
        $this->db->from('Buy');
        $this->db->where('Buy.buyerid', $user_id);
        $query = $this->db->get();
        return $query->result();
    }
    public function get_recom($user_id)
    {
        // get buy history
        $buydate = $this->get_max_buydate($user_id)[0]->buydate;

        $this->db->select('*');
        $this->db->from('Buy');
        $this->db->where('Buy.buydate', $buydate);
        $this->db->join('Item', 'Buy.itemid = Item.id');
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            $item = $query->result()[0];
            // return $itemid;

            // get all item
            $this->db->select('*');
            $this->db->from('Item');
            $this->db->where('ownerid !=', $user_id);
            $this->db->where('count !=', 0);
            $query = $this->db->get();
            // return $query->result();

            // $recomm_score = array();
            $tmp_list = $query->result();
            foreach ($query->result() as $rows) {
                $score = 0;
                if($rows->material != $item->material)
                {
                    $score = $score + 1;
                }
                if($rows->gender != $item->gender)
                {
                    $score = $score + 20;
                }
                if($rows->style != $item->style)
                {
                    $score = $score + 5;
                }
                if($rows->type != $item->type)
                {
                    $score = $score + 10;
                }
                $score = $score + abs(1 - ($rows->size / ($item->size+1))) * 10;
                $score = $score + abs(1 - ($rows->price / ($item->price+1))) * 10;

                // $recomm_score[$rows->id] = $score;
                $rows->score = $score;
            }
            usort($tmp_list, function($a, $b){
                return $a->score - $b->score;
            });

            $tmp_list = array_slice($tmp_list, 0, 4);
            $recomm_list = array();
            $recomm_list['isrecom'] = 1;
            $recomm_list['list'] = $tmp_list;
            return $recomm_list;
        }
        else
        {
            $this->db->select('*');
            $this->db->from('Item');
            // $this->db->where('ownerid !=', $user_id);
            // $this->db->where('count !=', 0);
            $query = $this->db->get();
            $num_item = sizeof($query->result());
            if($num_item > 4)
            {
                $num_item = 4;
            }
            $rand_keys = array_rand($query->result(), $num_item);
            $tmp_list = array();
            for ($i=0; $i < $num_item; $i++)
            {
                $tmp_list[] = $query->result()[$rand_keys[$i]];
            }
            // $tmp_list = array(
            //     $query->result()[$rand_keys[0]],
            //     $query->result()[$rand_keys[1]],
            //     $query->result()[$rand_keys[2]],
            //     $query->result()[$rand_keys[3]]
            //     );
            $recomm_list = array();
            $recomm_list['isrecom'] = 0;
            $recomm_list['list'] = $tmp_list;
            return $recomm_list;
        }
    }
    public function get_user_list($user_id)
    {
        $this->db->select('id, username');
        $this->db->from('User');
        $this->db->where('id !=', $user_id);
        $query = $this->db->get();
        return $query->result();
    }
    public function add_msg($msg, $recverid)
    {
        $data=array(
            'msg'=>$msg,
            'senderid'=>$this->session->userdata('user_id'),
            'recverid'=>$recverid
            );
        $this->db->insert('Msg', $data);
        echo '1';
    }
    public function add_msg2($msg, $recverid)
    {
        $data=array(
            'msg'=>$msg,
            'senderid'=>$this->session->userdata('user_id'),
            'recverid'=>$recverid
            );
        $this->db->insert('Msg', $data);
    }
    public function check_msg($user_id)
    {
        $this->db->select('*');
        $this->db->from('Msg');
        $this->db->where('recverid', $user_id);
        $this->db->where('readed', 0);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            echo 1;
        }
        else
        {
            echo 0;
        }
    }
    public function get_msg_list($user_id)
    {
        $this->db->from('Msg');
        $this->db->where('recverid', $user_id);
        $this->db->or_where('senderid', $user_id);
        $this->db->join('User AS User1', 'User1.id = Msg.recverid');
        $this->db->join('User AS User2', 'User2.id = Msg.senderid');
        $this->db->select('User1.username AS recvername, User2.username AS sendername, Msg.msg, Msg.postertime, Msg.msgid');
        $query = $this->db->get();
        foreach ($query->result() as $rows) {
            $this->db->where('msgid', $rows->msgid);
            $this->db->where('recverid', $user_id);
            $this->db->update('Msg', array('readed' => 1));
        }
        return $query->result();
    }
    public function set_msg_read($user_id)
    {
        // $this->db->where('msgid', $rows->msgid);
        // $this->db->where('recverid', $user_id);
        // $this->db->update('Msg', array('readed' => 1));
    }
}
?>