<?php

namespace Indiana\Queue;

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

class RuntimeException extends \RuntimeException {}