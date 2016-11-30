<?php

require '../vendor/autoload.php';

use Indiana\Queue\Pile;

$pile = new Pile();

$pile->setQueueName("OpTest")
	->setAttr("FIRST_ATTR_NAME12", 0)
	->setAttr("SECOND_ATTR_NAME2", "ATTR_VALUE2")
	->send();