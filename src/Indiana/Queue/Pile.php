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

use Aws\Sqs\SqsClient;
use Respect\Validation\Validator as v;

class Pile
{
	/**
	 * 
	 */
	private $queueName = '';

	private $queueUrl = "https://sqs.us-east-1.amazonaws.com/951717386538/OpTest";

	/**
	 *
	 * @var Array
	 */
	public $messageAttributes = array();

	/**
	 * [$messageBody description]
	 * @var string
	 */
	
	protected function arrayPopulate($attrName,$attrValue,$attrTypeValidated){

		/* MessageAttributes */

		array_push($this->messageAttributes, array($attrName => array(
			"StringValue" =>$attrValue, 
			"DataType" => $attrTypeValidated)));

			return $this->messageAttributes; 

	}

	protected $messageBody = 'SENT';

	/**
	 * [parseAttr description]
	 * @return [type] [description]
	 */
	private function parseAttr()
	{
	
	}
	/**
	 * @param  [String,Integer] 
	 * @return [$this]
	 */
	private function arrayValidate($value)
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
	
	/**
	 * [populateAMsgAttr description]
	 * @return [type] [description]
	 */
	private function populateMsgAttr($attrName, $attrValue){
		
		if(v::stringType()->notEmpty()->validate($attrValue)){
			$attrTypeValidated = "String";
			$result = $this->arrayPopulate($attrName,$attrValue,$attrTypeValidated);
			return $result;
			
		}elseif(v::intType()->notEmpty()->validate($attrValue)){
			$attrTypeValidated = "Number";	
			$result = $this->arrayPopulate($attrName,$attrValue,$attrTypeValidated);
			return $result;
			
		}else{
			throw new RuntimeException("Invalid attribute attrType for \'$attrType\'setted.");
		}
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

	/**
	 * [setAttr description]
	 * @param [string] $name  [only accepts string]
	 * @param [string, integer] $value [only accepts string on integer]
	 * Both $name and $value must be setted
	 */
	public function setAttr($name, $value)
	{		
		if(v::stringType()->notEmpty()->validate($name) && v::notEmpty()->validate($value)){
			if(v::stringType()->validate($value)){
				$this->populateMsgAttr($name, $value);	
				return $this;
			}else if(v::intType()->intVal()->validate($value)){
				$this->populateMsgAttr($name, $value);
				return $this;
			}else{
				throw new RuntimeException("Invalid attribute name for \'$name\' or \'$value' setted.");
			}
		}else{
			throw new RuntimeException("Invalid attribute name for \'$name\' or \'$value' setted.");
		}	
	}


	public function sendMessage(){

		$result = array(
			"QueueUrl"=> $this->queueUrl,
			"MessageBody" => $this->messageBody,
			"DelaySeconds" => 5
			 );

		
		$result['MessageAttributes'] = $this->messageAttributes;
	
		return $result;
	}
}


/*

$result = $client->sendMessage(array(
    // QueueUrl is required
    'QueueUrl' => 'string',
    // MessageBody is required
    'MessageBody' => 'string',
    'DelaySeconds' => integer,
    'MessageAttributes' => array(
        // Associative array of custom 'String' key names
        'String' => array(
            'StringValue' => 'string',
            'BinaryValue' => 'string',
            'StringListValues' => array('string', ... ),
            'BinaryListValues' => array('string', ... ),
            // DataType is required
            'DataType' => 'string',
        ),
        // ... repeated
    ),
));
 */

