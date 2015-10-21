<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<title><?php echo (isset($title)) ? $title : "My CI Site" ?> </title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/style.css" />
<!-- Bootstrap core CSS -->
<link href="<?php echo base_url();?>css/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap theme -->
<link href="<?php echo base_url();?>css/css/bootstrap-theme.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="<?php echo base_url();?>css/css/main.css" rel="stylesheet">
<!-- Custom styles for this template -->

<link href="<?php echo base_url();?>css/style.css" rel="stylesheet">


<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
<script src="<?php echo base_url();?>css/js/ie-emulation-modes-warning.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo base_url();?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>js/test.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.6/js/bootstrap-dialog.min.js"></script> -->

</head>
<body>
	<div id="wrapper">
		<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
         
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav" >
            <li class="active"><a href="<?php echo base_url()?>">Home</a></li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Category <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo base_url() ?>type?type=top">Top</a></li>
                <li><a href="<?php echo base_url() ?>type?type=bottom">Bottom</a></li>
                <li><a href="<?php echo base_url() ?>type?type=shoes">Shoes</a></li>
              </ul>
              <li><a href="<?php echo base_url() ?>about">About</a></li>
            <li><a href="<?php echo base_url() ?>contact">Contact</a></li>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li>
            <?php if($islogin){ ?>
            <a class="btn-outline btn-circle collapsed pull-right" href="<?php echo base_url()?>user/userhome"><?php echo $user ?></a>
            </li>
            <li>
              <?php echo anchor('user/logout', 'Logout'); ?>
            </li>
            <?php } else { echo $login_form;} ?>
            </li>
          </ul>
       
          
           <!-- <button type="button" class="btn btn-lg btn-success margin-left">Log In</button> -->
           <!-- <button type="button" class="btn btn-lg btn-success" id="sign_up">Sign Up</button> -->
        </div><!--/.nav-collapse -->
      </div>
    </nav>