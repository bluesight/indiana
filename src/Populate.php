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

namespace Indiana;

use Indiana\Exception;
use Aws\Sqs\SqsClient;
use Respect\Validation\Validator as v;

class Populate
{
	/**
	 * 
	 */
	const QUEUE_NAME = '';

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
			self::QUEUE_NAME = $queueName;
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

		if(v::intType()->validate($value)) {
			if (v::intVal()->validate($value){

			} else {
				throw new RuntimeException('Invalid interger value setted for \'$name\'.');
			}
		} 

		if(v::stringType()->notEmpty()->validate($value)) {
			
		} else {
			throw new RuntimeException('Invalid string value setted for \'$name\'.');
		}
	}

}