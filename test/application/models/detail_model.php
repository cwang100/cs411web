<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Detail_model extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
    }
	public function get_item_detail($item_id)
    {
        $this->db->select('Item.*, User.username AS ownername');
        $this->db->from('Item');
        $this->db->where('Item.id', $item_id);
        // $this->db->where('User.id', 'Item.ownerid');
        $this->db->join('User', 'User.id = Item.ownerid');
        $query = $this->db->get();
        return $query->result()[0];
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
            $this->db->update('Item', array('count' => $item_count));
            $this->db->insert('Buy', array('itemid' => $item_id, 'buyerid' => $user_id));
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
}
?>