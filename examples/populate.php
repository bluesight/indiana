<?php

require '../vendor/autoload.php';

use Indiana\Queue\Pile;

$pile = new Pile();

$pile->setQueueName("OpTest")
	->setAttr("FIRST_ATTR_NAME", "FIRST_ATTR_VALUE")
	->setAttr("SECOND_ATTR_NAME", "ATTR_VALUE")
	->send();