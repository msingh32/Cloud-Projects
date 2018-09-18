<?php
session_start();
header('Location:/process.php');
require 'vendor/autoload.php';

use Aws\Rds\RdsClient;
use Aws\Sqs\SqsClient;

$email=$_POST['email'];
$phone=$_POST['phone'];

echo $email;
echo $phone;

$sqsclient = SqsClient::factory(array(
       'version' => 'latest',
      'region'  => 'us-west-2'
));


$client = RdsClient::factory(array(
        'version' => 'latest',
        'region'  => 'us-west-2'
));

$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-west-2'
]);

$result = $client->describeDBInstances(array(
    'DBInstanceIdentifier' => 'mydb',
));

$address = $result['DBInstances'][0]['Endpoint']['Address'];

echo $address;

$conn = mysqli_connect($address,"msingh","asdf1234","db1",3306) or die("Error " . mysqli_error($link));

if(mysqli_connect_errno()) {
        printf("Connection failed: %s\n", mysqli_connect_error());
        exit();
}

echo "connection";

$name=$_FILES["photo"]["name"];
$tmp=$_FILES['photo']['tmp_name'];
$resultput = $s3->putObject(array(
             'Bucket'=>'itmo-544-msingh',
             'Key' =>  $name,
             'SourceFile' => $tmp,
             'region' => 'us-west-2',
             'ACL'    => 'public-read'
        ));
echo "raw input";
$raw_uri = $resultput['ObjectURL'];
$_SESSION['s3-raw']=$raw_uri;
$finishedurl="Yet_To_Upload";
echo $raw_uri;
echo $finishedurl;
$receipt=md5($raw_uri);
$sql = "CREATE TABLE IF NOT EXISTS test4
(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
email VARCHAR(32),
phone VARCHAR(32),
raw_url VARCHAR(200),
fin_url VARCHAR(200),
status INT(1),
receipt VARCHAR(200)
)";
$create_table = $conn->query($sql);

echo "table created";

if($create_table){
echo "table is inserted";
}
else{
echo "table error";
}

$stmt = "INSERT INTO test4(email,phone,raw_url,fin_url,status,receipt) VALUES ('$email','$phone','$raw_uri','$finishedurl',0, '$receipt')";
$conn->query($stmt);
echo $stmt;
$queueUrl="	https://sqs.us-west-2.amazonaws.com/605147794010/itmo-544-queue";
echo $queueUrl;
$_SESSION['receipt']=$receipt;
echo $receipt;
$sqsclient->sendMessage(array(
    'QueueUrl'    => $queueUrl,
    'MessageBody' => $_SESSION['receipt'],
));
echo "Done";

$stmt->close();
$conn->close();
?>
