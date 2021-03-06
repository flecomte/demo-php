<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use Producer\ArchiveIteratorFactory;
use Producer\CommitProducer;
use Producer\HistoryService;
use Producer\ProducerCommand;
use Symfony\Component\DependencyInjection\ContainerBuilder;

function configContainer(): ContainerBuilder
{
    $amq = new AMQPStreamConnection($_SERVER['RABBITMQ_HOST'], $_SERVER['RABBITMQ_PORT'], 'guest', 'guest');
    $channel = $amq->channel();
    $channel->queue_declare('commit', false, true, false, false);
    $channel->exchange_declare('commit', 'direct');
    $channel->queue_bind('commit', 'commit');

    $containerBuilder = new ContainerBuilder();
    $containerBuilder->autowire(ArchiveIteratorFactory::class, ArchiveIteratorFactory::class)
        ->addArgument(__DIR__.'/../var/cache')
        ->addArgument('http://data.gharchive.org');
    $containerBuilder->autowire(HistoryService::class, HistoryService::class);
    $containerBuilder->autowire(CommitProducer::class, CommitProducer::class)
        ->addArgument($channel);
    $containerBuilder->autowire(ProducerCommand::class, ProducerCommand::class)->setPublic(true);
    $containerBuilder->compile();

    return $containerBuilder;
}