<?php

require 'vendor/autoload.php'; 

use Indiana\Queue\Pile;



$user = new Pile();

$name = "cliente";
$value = 2;
$name2 = "cliente2";
$value2 = "texto2";
$name3 = "cliente3";
$value3 = "texto3";


$config = array(
	'version' => 'latest',
    'region'  => 'us-east-1');

$setArray = $user->setAttr($name,$value)->setAttr($name2,$value2)->setAttr($name3,$value3);

$sqs = new Aws\Sqs\SqsClient($config);
$sqs->sendMessage($user->configMessage());