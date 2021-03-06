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
    public function get_item($q)
    {
        $this->db->select('*');
        $this->db->from('Item');
        $this->db->like('name',$q);
        $query = $this->db->get();
        $result = array(
            "baseurl" => base_url(),
            "qresult" => $query->result()
            );
        if($query->num_rows > 0)
        {
            echo json_encode($result);
        }
    }
}
?>