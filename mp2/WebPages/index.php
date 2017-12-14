<?php
session_start();

?>
<html>
<head>
   
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
 
<body>
<div class="container">
<br/><br/>
 <div class="jumbotron">
 
<center><h3>Please select the option from the list</h3></center>
</div>
<br/><br/><br/><br/><br/>
<div class="row">
    <div class="col-md-2 col-md-offset-4">
		<a  href="/submit.php"><button type="button" style="padding:10px 80px;font-size:20px;" class="btn btn-primary btn-md">Submit Page</button></a>
	</div>
</div>
<br/>
<div class="row">
    <div class="col-md-2 col-md-offset-4">
		<a  href="/gall.php"><button type="button"  style="padding:10px 80px;font-size:20px;" class="btn btn-primary btn-md">Gallery Page</button></a>
	</div>
</div>
<br/>
<div class="row">
    <div class="col-md-2 col-md-offset-4">
		<a  href="/logout.php"><button type="button"  style="padding:10px 100px;font-size:20px;" class="btn btn-primary btn-md">Log Out</button></a>
	</div>
</div>
<br/>
<br/>
</div>
</div>
</body>
</html>