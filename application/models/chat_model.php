<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Chat_model extends CI_Model {
	 
	function __Construct()
    {
        parent::__Construct();
        session_start();
		$_SESSION['username'] = $this->session->userdata('user_name');
		date_default_timezone_set('America/Chicago');
    }

    function kill_session()
    {
    	session_destroy();
    }

	function chat_heartbeat()
	{
		$this->db->select('*');
		$this->db->from('Chat');
		$this->db->where('Chat.to', $_SESSION['username']);
		$this->db->where('recd', 0);
		$this->db->order_by("id", "asc");
		$query = $this->db->get();
		$items = array();

		foreach($query->result_array() as $chat)
		{
			if (!isset($_SESSION['opened_chat_box'][$chat['from']]) && isset($_SESSION['chat_history'][$chat['from']]))
			{
				$items = $_SESSION['chat_history'][$chat['from']];
			}
			$chat['message'] = $this->sanitize($chat['message']);
			$items[] = array(
				's' => 0,
				'f' => $chat['from'],
				'm' => $chat['message']
				);

			if(!isset($_SESSION['chat_history'][$chat['from']]))
			{
				$_SESSION['chat_history'][$chat['from']] = array();
			}

			$_SESSION['chat_history'][$chat['from']][] = array(
				's' => 0,
				'f' => $chat['from'],
				'm' => $chat['message']
				);
			
			unset($_SESSION['split_chat'][$chat['from']]);
			$_SESSION['opened_chat_box'][$chat['from']] = $chat['sent'];
		}

		if (!empty($_SESSION['opened_chat_box']))
		{
			foreach ($_SESSION['opened_chat_box'] as $chatbox => $time)
			{
				if (!isset($_SESSION['split_chat'][$chatbox]))
				{
					$diff = time()-strtotime($time);

					$message = "Sent at $time";
					if ($diff > 120)
					{
						$items[] = array(
							's' => 2,
							'f' => $chatbox,
							'm' => $message
							);

						if (!isset($_SESSION['chat_history'][$chatbox]))
						{
							$_SESSION['chat_history'][$chatbox] = array();
						}

						$_SESSION['chat_history'][$chatbox][] = array(
							's' => 2,
							'f' => $chatbox,
							'm' => $message
							);

						$_SESSION['split_chat'][$chatbox] = 1;
					}
				}
			}
		}

		$this->db->where('Chat.to', $_SESSION['username']);
		$this->db->where('recd', 0);
		$this->db->update('Chat', array('recd' => 1));

		$res = array('items' => $items);
		echo json_encode($res);
	}


	function start_chat()
	{
		$items = array();

		if (!empty($_SESSION['opened_chat_box']))
		{
			foreach ($_SESSION['opened_chat_box'] as $chatbox => $void)
			{
				if (isset($_SESSION['chat_history'][$chatbox]))
				{
					$items[] = $_SESSION['chat_history'][$chatbox];
				}
			}
		}

		$res = array();
		$res['username'] = $_SESSION['username'];
		$res['items'] = $items;
		echo json_encode($res);
	}

	function send_chat()
	{
		$from = $_SESSION['username'];
		$to = $_POST['to'];
		$message = $_POST['message'];

		$_SESSION['opened_chat_box'][$_POST['to']] = date('Y-m-d H:i:s', time());
		
		$messagesan = $this->sanitize($message);

		if (!isset($_SESSION['chat_history'][$_POST['to']]))
		{
			$_SESSION['chat_history'][$_POST['to']] = array();
		}

		$_SESSION['chat_history'][$_POST['to']][] = array(
			's' => 1,
			'f' => $to,
			'm' => $messagesan,
			);

		unset($_SESSION['split_chat'][$_POST['to']]);

		$this->db->insert('Chat', array(
			'from' => $from,
			'to' => $to,
			'message' => $message
			));
	}

	function close_chat()
	{

		unset($_SESSION['opened_chat_box'][$_POST['chatbox']]);
	}

	function sanitize($text)
	{
		$text = htmlspecialchars($text, ENT_QUOTES);
		$text = str_replace("\n\r","\n",$text);
		$text = str_replace("\r\n","\n",$text);
		$text = str_replace("\n","<br>",$text);
		return $text;
	}
 }
 ?>