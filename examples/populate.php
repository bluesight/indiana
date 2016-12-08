<?php

require '../vendor/autoload.php';

use Indiana\Queue\Pile;
$pile = new Pile();

echo "<pre>";
$a =$pile->setQueueName("OpTest")
	->setAttr("a", 1)
	->setAttr("secondname",2)
	->setAttr("third", "tres")
	->setAttr("fourth", "quatro")
	->setAttr("fifth", 5)
	->setAttr("sixth", 6)
	->setAttr("seventh", "sete")	
	->setAttr("eighth", 8)
	->setAttr("nineth", 9)
	->setAttr("tenth", "dez");