<?php

require 'vendor/autoload.php'; 

use Indiana\Queue\Pile;

$pile = new Pile();

$pile->setQueueName("YOUR_QUEUE_NAME")
	->setAttr("FIRST_ATTR_NAME", "FIRST_ATTR_VALUE")
	->setAttr("SECOND_ATTR_NAME", "ATTR_VALUE")
	->send();