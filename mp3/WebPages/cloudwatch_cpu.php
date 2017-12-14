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
        'Name' => 'InstanceId',
        'Value' => 'i-06283dea9cbee1ca1'
      ],
    ],
    'EndTime' => strtotime('now'), // REQUIRED
    'MetricName' => 'CPUUtilization', // REQUIRED
    'Namespace' => 'AWS/EC2', // REQUIRED
    'Period' => 3000, // REQUIRED
    'StartTime' => strtotime('-1 days'), // REQUIRED
    'Statistics' => ['SampleCount'],
   // 'Unit' => '
]);

echo (json_encode($cwresult['Datapoints']));
?>




