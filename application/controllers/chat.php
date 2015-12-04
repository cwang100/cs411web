<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Chat extends CI_Controller {

	//Global variable  
    public $outputData;
	public $loggedInUser;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('chat_model');
	}

    public function chatbox()
    {
    	if ($_GET['action'] == "chatheartbeat")
		{
			$this->chat_model->chat_heartbeat();
		}
		if ($_GET['action'] == "sendchat")
		{
			$this->chat_model->send_chat();
		}
		if ($_GET['action'] == "closechat")
		{
			$this->chat_model->close_chat();
		}
		if ($_GET['action'] == "startchat")
		{
			$this->chat_model->start_chat();
		}

    }
	

}
?>