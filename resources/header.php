<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?> :: Farm Game</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="<?php echo BASEURL;?>/resources/app.css" rel="stylesheet" id="bootstrap-css">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid"> 
    <div class="navbar-header">
      <span class="navbar-brand">Farm Game</span>      
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="<?php echo BASEURL;?>">Home</a></li>       
    </ul>
  </div>
</nav>
<div class="jumbotron text-center">
  <h3><?php echo $header_text; ?></h3>
  <?php if(isset($info_text)){
  	echo '<label class="label label-info">Note: '.$info_text.'</label>';
  } ?>
</div>
<!------ Include the above in your HEAD tag ---------->
