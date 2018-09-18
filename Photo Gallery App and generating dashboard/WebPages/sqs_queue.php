<?php
require 'vendor/autoload.php';
 //echo "hello world!\n";
$cw = new Aws\CloudWatch\CloudWatchClient([
    'version' => 'latest',
    'region'  => 'us-west-2'
]);
$cwresult = $cw->getMetricStatistics([
  'Dimensions' => [
      [
        'Name' => 'QueueName',
        'Value' => 'itmo-544-queue'
      ],
    ],
    'EndTime' => strtotime('now'), // REQUIRED
    'MetricName' => 'ApproximateNumberOfMessagesVisible', // REQUIRED
    'Namespace' => 'AWS/SQS', // REQUIRED
    'Period' => 3000, // REQUIRED
    'StartTime' =>strtotime('-1 days'), // REQUIRED
    'Statistics' => ['Sum'],
   // 'Unit' => '
]);

echo (json_encode($cwresult['Datapoints']));
?>


