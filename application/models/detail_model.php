<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Detail_model extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('America/Chicago');
    }
	public function get_item_detail($item_id)
    {
        $this->db->select('Item.*, User.username AS ownername');
        $this->db->from('Item');
        $this->db->where('Item.id', $item_id);
        // $this->db->where('User.id', 'Item.ownerid');
        $this->db->join('User', 'User.id = Item.ownerid');
        $query = $this->db->get();
        if($query->num_rows()>0)
        {
            return $query->result()[0];
        }
        else
        {
            return NULL;
        }
        
    }
    public function get_seller_status($ownerid)
    {
        if($this->session->userdata('user_id') == $ownerid)
        {
            return 2;
        }
        else
        {
            $this->db->select('online');
            $this->db->from('User');
            $this->db->where('id',$ownerid);
            $query = $this->db->get();
            return $query->result()[0]->online;
        }
    }
    public function buy_item($item_id, $user_id)
    {
        $this->db->select('count, ownerid');
        $this->db->from('Item');
        $this->db->where('id', $item_id);
        $query = $this->db->get();
        $item_count = $query->result()[0]->count;
        $item_ownerid = $query->result()[0]->ownerid;
        if($item_count && $item_ownerid != $this->session->userdata('user_id'))
        {
            $item_count--;
            $this->db->where('id',$item_id);
            $this->db->update('Item', array('count' => $item_count));
            $this->db->insert('Buy', array('itemid' => $item_id, 'buyerid' => $user_id, 'buydate' => date("Y-m-d H:i:s", time())));
            return 1;
        }
        elseif ($item_ownerid == $this->session->userdata('user_id')) {
            return 2;
        }
        else
        {
            return 0;
        }
    }
    public function get_item_list($user_id, $item_id)
    {
        $this->db->select('id, name, img');
        $this->db->from('Item');
        $this->db->where('ownerid', $user_id);
        $this->db->where('id !=', $item_id);
        $query = $this->db->get();
        if($query->num_rows() < 3)
        {
            return $query->result();
        }
        else
        {
            $rand_keys = array_rand($query->result(), 3);
            return array(
                $query->result()[$rand_keys[0]],
                $query->result()[$rand_keys[1]],
                $query->result()[$rand_keys[2]]
                );
        }
    }
    public function remove_item($item_id)
    {
        $this->db->delete('Item', array('id' => $item_id));
    }
    public function send_buy_msg($item_detail)
    {
        $msg = $this->session->userdata('user_name')." has bought your item ".$item_detail->name.", you may contact him/her now!";
        $data=array(
            'msg'=>$msg,
            'senderid'=>$this->session->userdata('user_id'),
            'recverid'=>$item_detail->ownerid
            );
        $this->db->insert('Msg', $data);
    }
}
?>