<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Type_model extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
    }
    public function getTop()
    {
    	$this->db->select('name, img');
    	$this->db->from('Item');
    	$this->db->join('Top', 'Top.id = Item.id');
    	$query = $this->db->get();
    	return $query->result();
    }
}
?>