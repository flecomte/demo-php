<?php

use Consumer\CommitService;
use Consumer\Consumer;
use Consumer\ConsumerCommand;
use FLE\JsonHydrator\Database\Connection;
use FLE\JsonHydrator\Repository\RepositoryFactory;
use FLE\JsonHydrator\Serializer\EntityCollection;
use FLE\JsonHydrator\Serializer\Serializer;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Symfony\Component\DependencyInjection\ContainerBuilder;

function configContainer(): ContainerBuilder
{
    $amq = new AMQPStreamConnection($_SERVER['RABBITMQ_HOST'], $_SERVER['RABBITMQ_PORT'], 'guest', 'guest');
    $channel = $amq->channel();
    $channel->queue_declare('commit', false, true, false, false);

    $jmsSerializer = JMS\Serializer\SerializerBuilder::create()->build();
    $serializer = new Serializer($jmsSerializer, null, null);

    $containerBuilder = new ContainerBuilder();

    $containerBuilder->autowire(Serializer::class, Serializer::class)
        ->setArgument('$jmsSerializer', $jmsSerializer);

    $containerBuilder->autowire(EntityCollection::class, EntityCollection::class);
    $containerBuilder->autowire(Connection::class, Connection::class)
        ->addArgument('yst')
        ->addArgument('db')
        ->addArgument('5432')
        ->addArgument('yst')
        ->addArgument('yst')
        ->addArgument('yst')
        ->setArgument('$stopwatch', null);

    $containerBuilder->autowire(RepositoryFactory::class)
        ->setArgument('$serializer', $serializer);
    $containerBuilder->autowire(Consumer::class, Consumer::class)
        ->addArgument($channel);
    $containerBuilder->autowire(CommitService::class, CommitService::class);
    $containerBuilder->autowire(ConsumerCommand::class, ConsumerCommand::class)->setPublic(true);
    $containerBuilder->compile();

    return $containerBuilder;
}
