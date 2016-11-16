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

namespace Sqs\Populate;

use Sqs\Populate\Exception;
use Aws\Sqs\SqsClient;

class Populate 
{
	/**
	 * 
	 */
	const QUEUE_URL = '';

	/**
	 *
	 * @var Array
	 */
	private $messageAttributes = '';

	/**
	 * [$messageBody description]
	 * @var string
	 */
	protected $messageBody = '';

	/**
	 * [$delaySeconds description]
	 * @var string
	 */
	protected $delaySeconds = '';

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
	public function setQueueUrl($urlQueue)
	{

	}

	/**
	 * [setMessageBody description]
	 * @param [type] $body [description]
	 */
	public function setMessageBody($body)
	{

	}

	/**
	 * [setAttr description]
	 * @param [type] $name  [description]
	 * @param [type] $value [description]
	 */
	public function setAttr($name, $value)
	{

	}

}