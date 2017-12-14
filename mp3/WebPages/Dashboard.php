<?php
session_start();
require 'vendor/autoload.php';

use Aws\Rds\RdsClient;
$email=$_POST['email'];

$client = RdsClient::factory(array(
        'version' => 'latest',
        'region'  => 'us-west-2'
));

$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-west-2'
]);

$result = $client->describeDBInstances(array('DBInstanceIdentifier' => 'mydb1'));

$address = $result['DBInstances'][0]['Endpoint']['Address'];


$conn = mysqli_connect($address,"msingh","asdf1234","db1","3306") or die("Error " . mysqli_error($link));

if(mysqli_connect_errno()) {
        printf("Connection failed: %s\n", mysqli_connect_error());
        exit();
}

$abc="SELECT count(status) as c FROM test4 WHERE status=1";
$result1=mysqli_query($conn,$abc);
if($result1)
 {
    while($row=mysqli_fetch_assoc($result1))
  {
	  $e=$row['c'];
        echo $e ;
  }     
 }
 $abc1="SELECT count(status) as d FROM test4 WHERE status=0";
$result2=mysqli_query($conn,$abc1);
if($result2)
 {
    while($row=mysqli_fetch_assoc($result2))
  {
	  $f=$row['d'];
        echo $f;
  }     
 }
 ?>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="app.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
      <script type="text/javascript" src="app.js"></script>

      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
  <div class="row">
    <div class="col-md-4">
    <div class="w3-container">
    <div class="w3-card-4" style="width:70%">
      <header class="w3-container w3-light-grey">
        <h3>SQS Queue</h3>
      </header>
      <div class="w3-container">
        <p id="jobvisible">Completed Tasks:<h4><?php echo $e;?></h4></p><br>
         <hr>
        <p id="jobInvisible">Incompleted Tasks:<h4><?php echo $f;?></h4></p><br>
         <hr>
        <p id="nmsg">Number of Messages: <h4><?php echo $f+$e ;?></h4></p><br>
      </div>
    </div>
  </div>
</div>
<div class="col-md-4 col-md-offset-3">
<div class="w3-container">
<div class="w3-card-4" style="width:70%">
  <header class="w3-container w3-light-grey">
    <h3>Dashboard Details</h3>
  </header>
  <div class="w3-container">
   <a href="chart.html" class="btn btn-primary">DashBoard Details</a><br>
  </div>
</div>
</div>
</div>
 </div>
</body>
</html>
