<?php

require 'vendor/autoload.php'; 

use Indiana\Queue\Pile;



$user = new Pile();

$name = "cliente";
$value = 2;
$name2 = "cliente2";
$value2 = "texto2";


$config = array(
	'version' => 'latest',
    'region'  => 'us-east-1');


$sqs = new Aws\Sqs\SqsClient($config);
$sqs->sendMessage($user->sendMessage());

/*

$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-east-1'
]);

 */