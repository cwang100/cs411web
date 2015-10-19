<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Type_model extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
    }
    public function get_itemlist($item_type)
    {
        $this->db->select('*');
        $this->db->where('type', $item_type);
        $this->db->from('Item');
        $query = $this->db->get();
        return $query->result();
    }
    public function getTop()
    {
    	$this->db->select('Item.id, name, img');
    	$this->db->from('Item');
    	$this->db->join('Top', 'Top.id = Item.id');
    	$query = $this->db->get();
    	return $query->result();
    }
}
?>