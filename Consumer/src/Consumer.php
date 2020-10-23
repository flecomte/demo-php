<?php

namespace Consumer;

use PhpAmqpLib\Channel\AMQPChannel;

class Consumer
{
    private AMQPChannel $channel;

    public function __construct(AMQPChannel $channel)
    {
        $this->channel = $channel;
    }

    public function consume($callback)
    {
        $this->channel->basic_consume('commit', '', false, true, false, false, $callback);

        while (true) {
            $this->channel->wait();
        }
    }
}