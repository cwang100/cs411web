<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Type_model extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
    }
    public function getTop()
    {
    	$query = $this->db->get("Top");
    	return $query->result();
    }
}
?>