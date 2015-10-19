<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Detail_model extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
    }
	public function get_item_detail($item_id)
    {
        $this->db->select('*');
        $this->db->from('Item');
        $this->db->where('id', $item_id);
        // $this->db->join('');
        $query = $this->db->get();
        return $query->result()[0];
    }
}
?>