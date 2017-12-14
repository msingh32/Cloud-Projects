<?php
require 'vendor/autoload.php';
header('Location:/gallery.php');
use Aws\Rds\RdsClient;

use Aws\Sqs\SqsClient;

$sqsclient = SqsClient::factory(array(
       'version' => 'latest',
      'region'  => 'us-west-2'
));

$sns = new Aws\Sns\SnsClient([
    'version' => 'latest',
    'region'  => 'us-west-2'
]);

$client = RdsClient::factory(array(
'version' => 'latest',
'region'  => 'us-west-2'
));
$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-west-2'
]);
$queueUrl ="https://sqs.us-west-2.amazonaws.com/605147794010/itmo-544-queue";
//echo $queueUrl;
$result = $client->describeDBInstances(array(
    'DBInstanceIdentifier' => 'itmo-544-mydb',
));

$address = $result['DBInstances'][0]['Endpoint']['Address'];

//echo $address;
$conn = mysqli_connect($address,"msingh","asdf1234","db1",3306) or die("Error " . mysqli_error($link));
//echo "Suceesfully Connected";
$sqsresult = $sqsclient->receiveMessage(array(
    // QueueUrl is required
    'QueueUrl' => $queueUrl,
    'VisibilityTimeout' => 300,//Hiding the message for 300 seconds
  'MaxNumberOfMessages' => 1,
));

//echo "Sqs Result done";

$messagebodyfromsqs=$sqsresult['Messages'][0]['Body'];
$receipttodelete=$sqsresult['Messages'][0]['ReceiptHandle'];

//echo $messagebodyfromsqs;
//echo "Record fetched";

if (!empty($messagebodyfromsqs)){
//echo "Inside If loop" . "\n";
$sqlselect = "SELECT email,raw_url,fin_url FROM records where receipt='$messagebodyfromsqs'";
$resultforselect = $conn->query($sqlselect);
$rawurl="";
while($row= $resultforselect->fetch_assoc()){
                $rawurl=$row["raw_url"];
          //      echo $rawurl . "\n";
				$email=$row["email"];
}
//echo $rawurl;
//echo  "record sucessfully fetched";
//$conn->close();
//$image_raw="";
$checkimgformat=substr($rawurl, -3);

if($checkimgformat == 'png' || $checkimgformat == 'PNG'){
    $image_raw=imagecreatefrompng($rawurl);
        }
//echo "test1 passed";
else{
    $image_raw = imagecreatefromjpeg($rawurl);
}
//echo 'records passed";
if($image_raw && imagefilter($image_raw, IMG_FILTER_GRAYSCALE))
{
    $gray_uploaddir = '/tmp_grayscale/';
    $gray_uploadfile = $gray_uploaddir.basename($rawurl);
    imagepng($image_raw, $gray_uploadfile);
}
Else
{
    echo 'Conversion to grayscale failed.';
}
//echo "Transformed";
echo $gray_uploadfile;
echo basename($rawurl);
$resultimg = $s3->putObject(array(
    'Bucket' => 'itmo-544-trans',
    'Key'    =>  basename($rawurl),
     'SourceFile' => $gray_uploadfile,
    'ACL' => 'public-read'
));
echo "Done Bucket";
//echo "fin input";
$finishedimageurl=$resultimg['ObjectURL'];
imagedestroy($image_raw);

$sqlselect = "UPDATE records SET fin_url='$finishedimageurl',status=1 WHERE receipt='$messagebodyfromsqs'";
$resultforselect = $conn->query($sqlselect);

$result=$sns->subscribe(array(
'TopicArn'=>'arn:aws:sns:us-west-2:605147794010:itmo-544-email',
'Protocol'=>'email',
'Endpoint'=>$email
));

if($result)
{
	echo "Sns Send";
}
else
{
	echo "Sns not send";
}
$sqsresult=$sqsclient->deleteMessage([
	'QueueUrl'=>$queueUrl,
	'ReceiptHandle'=>$receipttodelete
	]);
	echo "Deleted Message";
$conn->close();
}
?>

