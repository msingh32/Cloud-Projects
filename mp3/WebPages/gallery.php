
<?php
session_start();
require 'vendor/autoload.php';

use Aws\Rds\RdsClient;

$client = RdsClient::factory(array(
        'version' => 'latest',
        'region'  => 'us-west-2'
));

$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-west-2'
]);

$result = $client->describeDBInstances(array('DBInstanceIdentifier' => 'itmo-544-mydb'));

$address = $result['DBInstances'][0]['Endpoint']['Address'];


$conn = mysqli_connect($address,"msingh","asdf1234","db1","3306") or die("Error " . mysqli_error($link));

if(mysqli_connect_errno()) {
        printf("Connection failed: %s\n", mysqli_connect_error());
        exit();
}

$conn->real_query("SELECT * FROM records where status=1");
$res = $conn->use_result();
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

<center><h3>Transformed and Original Images </h3></center>
</div>




                                                                <div class="row">
   
                <div class="col-md-2 col-md-offset-11" style="right:30px">
                <a  href="/index.php"><button type="button"  style="position:fixed" class="btn btn-primary btn-md">Home Page</button$
                                </div>
                         </div>
                        <br/><br/><br/><br/><br/><br/>

						              <div class="second_div">
                                <div style="position:fixed" class="col-md-2 col-md-offset-5"><h4>Transformed Image</h4></div>
                          <?php      while ($row = $res->fetch_assoc()) {
                                ?>
                                                <div class="row">
                                                <div class="col-md-2 col-md-offset-3">
                        <img src="<?php echo $row['raw_url']; ?>" alt="" width="200" height="200">
                                                </div>

                          <div class="col-md-2 col-md-offset-3">
                        <img src="<?php echo $row['fin_url']; ?>" alt="" width="200" height="200">
                                                </div>
                                </div>
                        <?php
           }
                        ?>
						                       
                </div>
                                </div>
        </body>
</html>

