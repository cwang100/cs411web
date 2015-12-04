<?php
	// session_start(); // This is need.Otherwise not getting your name in the chat box.
	$_SESSION['username'] = $this->session->userdata('username'); // Must be already set
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    
	<title>CodeIgniter Demo - Chat</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<!-- <script type="text/javascript" src="<?php echo base_url();?>/js/chat.js"></script> -->

  <script type="text/javascript">
  var baseurl = "<?php print base_url(); ?>";
</script>
  
    <link type="text/css" rel="stylesheet" media="all" href="<?php echo base_url();?>/css/chat.css" />
    <link type="text/css" rel="stylesheet" media="all" href="<?php echo base_url();?>/css/screen.css" />
    
    <!--[if lte IE 7]>
    <link type="text/css" rel="stylesheet" media="all" href="http://demo.webexplorar.com/codeigniter/application/css/screen_ie.css" />
    <![endif]--> 

</head>
<body>

<div id="container">

	<h2>Online Users</h2>

     <table width="45%" cellspacing="1" cellpadding="2" class="tableContent" style="margin-left:0px !important;">
        <tbody>
          <tr style="background-color:#9EB0E9;  font-size:13px; font-weight:bold; color:#fff;">
            <th>Online</th>
            <th>User Id</th>
            <th>User Name</th>
          </tr>
                              
		<?php
								
		if(isset($listOfUsers))
		{
			foreach($listOfUsers->result() as $res)
			{
		?>

          <tr style="background-color:#efefef;">
            <td><?php if($res->online==1) echo 'Active'; else echo 'Inactive'; ?></td>
            <td><?php echo $res->user_id; ?></td>
            <td><?php if($_SESSION['username']==$res->user_name) { ?>
                 		<a href="#" style="text-decoration:none">
                      <?php } else { ?>  
                        <a href="javascript:void(0)" onClick="javascript:chatWith('<?php echo $res->user_name; ?>');">
                <?php } ?>      
                <?php echo $res->user_name;  ?>
                        </a>
                  </td>
            </tr>
			<?php 	
										 
			} // end foreach loop
		} // end if condition
		?>	  	  	
			
		</tbody>
	</table>
    
 </div>

</body>
</html>   