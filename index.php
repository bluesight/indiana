<?php

require 'vendor/autoload.php'; 
require 'src/Indiana/Queue/Indiana.php'; 
require 'src/Indiana/Queue/RunTimeException.php';
use Indiana\Queue\Pile;
use Indiana\Queue\RunTimeException;


$user = new Pile();

$name = "cliente";
$value = 2;


var_dump($user->setAttr($name,$value));

?>