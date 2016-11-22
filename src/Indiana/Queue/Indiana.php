<?php

/**
 *
 *
 *
 *
 *
 *
 *
 *
 * 
 */

namespace Indiana\Queue;

use Indiana\Exception;
use Aws\Sqs\SqsClient;
use Respect\Validation\Validator as v;

class Pile
{
	/**
	 * 
	 */
	private $queueName = '';

	/**
	 *
	 * @var Array
	 */
	private $messageAttributes = array();

	/**
	 * [$messageBody description]
	 * @var string
	 */
	protected $messageBody = 'SENT';

	/**
	 * [parseAttr description]
	 * @return [type] [description]
	 */
	private function parseAttr()
	{
	
	}

	/**
	 * [setQueueUrl description]
	 * @param [type] $urlQueue [description]
	 */
	public function setQueueName($queueName)
	{

		if(v::stringType()->validate($queueName)){
				define(QUEUE_NAME,$queueName);

		} else {
			throw new RuntimeException('Invalid QUEUE_NAME setted.');
		}
	}

	/**
	 * [setMessageBody description]
	 * @param [type] $body [description]
	 */
	public function setMessageBody($body)
	{
		if(v::json()->validate($body)){
			$this->messageBody = $body;
		} else {
			throw new RuntimeException('Invalid messageBody setted.');
		}
	}

	/* */
	function testArray($value)
	{
		foreach($value as $key){
		if(!v::stringType()->validate($key)){			
		$notString[] = $key;
		}else{
		$isString[] = $key;
		}
	}
	if(v::nullType()->validate($notString)){
		$value = $isString;
		return $value;	
	}else{
		$result = $notString;
		return "Invalid attribute integer setted.";
		}
	}
	/*
	*/

	public function valAttr($value)
	{
		if(v::arrayType()->validate($value)){
			$newValue = implode($value,",");
			return $newValue;
		}elseif(v::stringType()->validate($value)){
			$newValue = $value;
			return $newValue;
		}elseif(v::intType()->validate($value)){
			$newValue = $value;
			return $value;
		}else {
			throw new RuntimeException('Invalid parameter value setted for \'$value\'.');
		}
	}

	/**
	 * [setAttr description]
	 * @param [type] $name  [description]
	 * @param [type] $value [description]
	 */
	public function setAttr($name, $value)
	{
		if(!v::stringType()->notEmpty()->validate($name)){
			throw new RuntimeException('Invalid attribute name for \'$name\' setted.');
		}

		if(v::intType()->validate($value)){
			if(v::intVal()->validate($value)){

			} else {
				throw new RuntimeException('Invalid interger value setted for \'$name\'.');
			}
		} 

		if(v::stringType()->notEmpty()->validate($value)) {
			
		} else {
			throw new RuntimeException('Invalid string value setted for \'$name\'.');
		}
		return $this;
	}

}