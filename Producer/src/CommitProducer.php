<?php

namespace Producer;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

class CommitProducer
{
    private AMQPChannel $channel;

    public function __construct(AMQPChannel $channel)
    {
        $this->channel = $channel;
    }

    public function send(string $message)
    {
        $msg = new AMQPMessage($message);
        $this->channel->basic_publish($msg, 'commit', '');
    }
}