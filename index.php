<?php

require 'vendor/autoload.php'; 
require 'src/Indiana/Queue/Indiana.php'; 
use Indiana\Queue\Pile;

$user = new Pile();


$value = array('email1@uol.com.br', 'email2@bol.com.br', 'email3@aol.com.br');


var_dump($user->testArray($value));

?>