<?php

namespace Indiana\Queue;

use Aws\Sqs\SqsClient;
use Respect\Validation\Validator as v;

/**
 * Indiana Queue
 *
 * It's a litle wrapper to help applications send messages to 
 * queues in Amazon SQS.
 *
 * @package indiana
 * @subpackage Queue
 * @author Wallison Marra
 * @author Bruno Alves
 * @copyright Indiana Queue (c) Blue Sight 
 * @link https://aws.amazon.com/sqs/
 * 
 */

class Pile
{
	/**
	 * @var String Default AWS API Version
	 */
	private $sqsApiVersion = 'latest';

	/**
	 * @var String Default AWS region
	 */
	private $awsRegion = 'us-east-1';

	/**
	 * @var Integer Delay seconds to make message visible in the queue named
	 */
	private $delaySeconds = 5;

	/**
	 * @var String
	 */
	private $messageId = "";

	/**
	 * @var array
	 */
	private $messageIdGroup = array();

	/**
	 * @var Integer Count attrs addes in $messageAttributes
	 */
	private $count = 0;

	/**
	 * @var String Message body to send to the queue
	 */
	private $messageBody = 'Empty';

	/**
	 * @var Array Object to increment all attributes to send to the queue. This var is limited by 10 attributes
	 */
	private $messageAttributes = array();

	/**
	 * @var String Queue name
	 */
	private $queueName = '';

	/**
	 * @var String URL Queue
	 */
	private $queueUrl = '';

	/**
	 * @var Array All configured object queue to send
	 */
	private $queueObjToSend = array();

	/**
	 * Verifiy te type of DataType and set String or Number
	 * @param String $attrName attribute name
	 * @param (Interger|String) $attrValue attribute value
	 * @return Array Data will be increased in messageAttributes var
	 * @throws RunTimeException
 	 */
	private function populateMsgAttr($attrName, $attrValue)
	{
		if(v::stringType()->notEmpty()->validate($attrValue)){
			$attrTypeValidated = "String";
			$this->addMessageAttribute($attrName,$attrValue,$attrTypeValidated);
		}elseif(v::intType()->notEmpty()->validate($attrValue) || ($attrValue === 0)){
			$attrTypeValidated = "Number";	
			$this->addMessageAttribute($attrName,$attrValue,$attrTypeValidated);
		}else{
			throw new RunTimeException("Invalid attribute attrType for \'$attrType\'setted.");
		}
	}

	/**
	 * Each interation will be increased in messageAttributes
	 * @param String $attrName Must be String
	 * @param (String|Integer) $attrValue Must be String or Integer
	 * @param String $attrTypeValidated String with values "string" or "number"
	 * @return Array Returns array to be setted on message attribute
	 * @throws RunTimeException
	 */
	private function addMessageAttribute($attrName,$attrValue,$attrTypeValidated)
	{
		if(array_key_exists($attrName, $this->messageAttributes)){
			throw new RunTimeException("Invalid attribute \'$attrName\' for messageAttributes array. Key name already setted!");
		}
		$this->messageAttributes[$attrName] = [
			"StringValue" => $attrValue, 
			"DataType"    => $attrTypeValidated
		];
		return $this->messageAttributes; 
	}

	/**
	 * Get url for the queue named
	 * @return Indiana\Queue\Pile
	 * @throws RunTimeException
	 */
	private function getQueueUrl()
	{
		$sqs = $this->setSqsClient();
		$url = $sqs->getQueueUrl(
			array('QueueName' => $this->queueName)
		);

		if(!$url->get('QueueUrl')) {
			throw new RunTimeException("Invalid Queue Name");
		}

		$this->queueUrl = $url->get('QueueUrl');
		return $this;
	}

	/**
	 * Configuring SQS object to send
	 * Ps: MessageBody is required by the queue, so if wasn't setted, we configure it with default
	 * @return Void
	 */
	private function configSqsObj()
	{
		$this->queueObjToSend = array(
			"QueueUrl"			=> $this->queueUrl,
			"MessageBody" 		=> $this->messageBody,
			"DelaySeconds"	 	=> $this->delaySeconds,
			'MessageAttributes' => $this->messageAttributes
		);
		return $this;
	}

	/**
	 * Prepare AWS SqsClient
	 * @return Object AWs\Sqs\SqsClient
	 */
	private function setSqsClient()
	{
		return new SqsClient(
			array(
				'version' => $this->sqsApiVersion,
			    'region'  => $this->awsRegion
			)
		);
	}

	/**
	 * Set queue name
	 * @param String $sqsApiVersion Queue name will be setted here
	 * @return Indiana\Queue\Pile
	 * @throws RuntimeException
	 */
	public function setSqsApiVerison($sqsApiVersion)
	{
		if(v::stringType()->notEmpty()->validate($sqsApiVersion)){
			$this->sqsApiVersion = $sqsApiVersion;
		} else {
			throw new RunTimeException("Invalid string value to sqsApiVersion parameter.");
		}
		return $this;
	}

	/**
	 * Set aws region name
	 * @param String $region AWS Region name
	 * @return Indiana\Queue\Pile
	 * @throws RuntimeException
	 */
	public function setAwsRegion($region)
	{
		if(v::stringType()->notEmpty()->validate($region)){
			$this->awsRegion = $region;
		} else {
			throw new RunTimeException("Invalid string value to region parameter.");
		}
		return $this;
	}

	/**
	 * Set aws region name
	 * @param Integer $delaySeconds AWS Region name
	 * @return Indiana\Queue\Pile
	 * @throws RuntimeException
	 */
	public function setDelaySeconds($delaySeconds)
	{
		if(v::intType()->notEmpty()->validate($delaySeconds)){
			$this->delaySeconds = $delaySeconds;
		} else {
			throw new RunTimeException("Invalid integer value to delaySeconds parameter.");
		}
		return $this;
	}
	
	/**
	 * Set queue name
	 * @param String $queueName Queue name will be setted here
	 * @return Indiana\Queue\Pile
	 * @throws RuntimeException
	 */
	public function setQueueName($queueName)
	{
		if(!v::stringType()->notEmpty()->validate($this->queueName)){
			$this->queueName = $queueName;
		} else {
			throw new RunTimeException("Invalid string value to queueName parameter.");
		}
		return $this;
	}

	/**
	 * Validate paramters before insert to the queue
	 * @param String $name Only accepts string
	 * @param String,Integer $value Only accepts string on integer
	 * @return Indiana\Queue\Pile
	 * @throws RuntimeException
	 */
	public function setAttr($name, $value)
	{	
		$this->countAttrs();
		if(v::stringType()->notEmpty()->validate($name) && isset($value)){
			if(v::stringType()->validate($value)){
				$this->populateMsgAttr($name, $value);	
			}else if(v::intType()->intVal()->validate($value) || ($value === 0)){
				$this->populateMsgAttr($name, $value);
			}else{
				throw new RunTimeException("Invalid attribute name for $name: $value setted.");
			}
		}else{
			throw new RunTimeException("Invalid attributes name and value. Was setted: '$name' and '$value'");
		}
		return $this;
	}

	/**
	 * Keep attr increment control
	 * @return Void
	 * @throws RuntimeException
	 */
	public function countAttrs()
	{
		if($this->count >= 10){
			throw new RunTimeException("Attributes setted are higher than 10");
		}
		$this->count++;	
	}

	/**
	 * Register ID that identificate message batch
	 * @param  String $id MD5 hash identifing ID message of send batch message.
	 * @return Object Indiana\Queue\Pile
	 */
	public function saveMessageBatchId($id)
	{
		$this->messageIdGroup[] = $id;
		return $this;
	}

	/**
	 * Construct the array to be setted and sended by aws
	 * @return Void
	 */
	public function configBatch()
	{ 
		$this->saveMessageBatchId(md5(time()));
		$this->queueObjToSendBatch = array(
			"QueueUrl"=> $this->queueUrl,
			"Entries" => array(
				array(
				"Id" 				=> $idmd5,
				"MessageBody" 		=> $this->messageBody,
				"DelaySeconds" 		=> $this->delaySeconds,
				"MessageAttributes" => $this->messageAttributes)
			)
		);
		return $this->queueObjToSendBatch;
	}

	/**
	 * Send message attributes and message body to queue up to 10 attributtes
	 * @return Object returned by Aws\Sqs\SqsClient sendMessage method
	 */
	public function sendBatch()
	{
		$data = $this->configBatch()->setSqsClient()
					->sendMessageBatch($this->queueObjToSendBatch);

		return $data;	
	}
	
	/**
	 * Send message attributes and message body to the queue named
	 * @return object Object returned by Aws\Sqs\SqsClient sendMessage method
	 */
	public function send()
	{
		$data = $this->getQueueUrl()
					->configSqsObj()
					->setSqsClient()
					->sendMessage($this->queueObjToSend);
		return $data;
	}	
}
