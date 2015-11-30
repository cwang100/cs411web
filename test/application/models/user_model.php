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

            $recomm_list = array();
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

                $recomm_list[$rows->id] = $score;
            }
            asort($recomm_list);

            return $recomm_list;

            // calculate score
            // sort
            // return recomm items
        }
    }
}
?>