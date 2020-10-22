<?php

namespace Consumer;

use FLE\JsonHydrator\Repository\RepositoryFactory;
use PhpAmqpLib\Message\AMQPMessage;

class HistoryService
{
    private Consumer $consumer;
    private HistoryRepository $repository;

    public function __construct(Consumer $consumer, RepositoryFactory $repositoryFactory)
    {
        $this->consumer = $consumer;
        $this->repository = $repositoryFactory->getRepository(HistoryRepository::class);
    }

    public function saveHistoryFromQueue()
    {
        $this->consumer->consume(fn(AMQPMessage $msg) => $this->repository->insert($msg->body));
    }
}