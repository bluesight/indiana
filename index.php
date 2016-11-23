<?php

require 'vendor/autoload.php'; 
require 'src/Indiana/Queue/Indiana.php'; 
require 'src/Indiana/Queue/RunTimeException.php';
use Indiana\Queue\Pile;
use Indiana\Queue\RunTimeException;


$user = new Pile();

$name = "cliente";
$value = 2;

echo "<pre>";
var_dump($user->sendMessage($name,$value));

/*

$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-east-1'
]);

 */