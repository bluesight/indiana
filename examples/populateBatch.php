<?php

require '../vendor/autoload.php';

use Indiana\Queue\Pile;

$pile = new Pile();

$queueName = "OpTest";
$pile->setQueueName($queueName);
$count = 0;

$array = [
	"nameBatch1"  => "ValueBatch1",
	"nameBatch2"  => 2,
	"nameBatch3"  => "valueBatch3",
	"nameBatch4"  => "valueBatch4",
	"nameBatch5"  => "valueBatch5",
	"nameBatch6"  => "valueBatch6",
	"nameBatch7"  => "valueBatch7",
	"nameBatch8"  => "valueBatch8",
	"nameBatch9"  => "valueBatch9",
	"nameBatch10" => "valueBatch10"		
];
/**
 * [$value description]
 * @var $count [integer]
 * must be setted at maximum 10
 */
foreach($array as $value => $key){

	$pile->setAttr($value,$key)
		->setBatchMessage();
	if($count == 9){
		$pile->configBatch();
		$pile->sendBatch();
		$count = 0;
	}
	$count++;
}