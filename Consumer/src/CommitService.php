<?php

namespace Consumer;

use FLE\JsonHydrator\Repository\RepositoryFactory;
use PhpAmqpLib\Message\AMQPMessage;

class CommitService
{
    private Consumer $consumer;
    private CommitRepository $repository;

    public function __construct(Consumer $consumer, RepositoryFactory $repositoryFactory)
    {
        $this->consumer = $consumer;
        $this->repository = $repositoryFactory->getRepository(CommitRepository::class);
    }

    public function saveCommitsFromQueue()
    {
        $this->consumer->consume(fn(AMQPMessage $msg) => $this->repository->insert($msg->body));
    }
}