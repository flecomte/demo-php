<?php

namespace Producer;

class HistoryService
{
    private ArchiveIteratorFactory $archiveIteratorFactory;
    private CommitProducer $producer;

    public function __construct(ArchiveIteratorFactory $archiveIteratorBuilder, CommitProducer $producer)
    {
        $this->archiveIteratorFactory = $archiveIteratorBuilder;
        $this->producer = $producer;
    }

    /**
     * Get data from GH Archive, and push to RabbitMQ the commits information
     *
     * @throws ArchiveIteratorException
     */
    public function pushCommits(string $date): \Generator
    {
        $i = 0;
        foreach ($this->archiveIteratorFactory->build($date) as $lineContent) {
            $data = json_decode($lineContent, true);
            if ($data['type'] == 'PushEvent' && isset($data['payload']['commits'])) {
                $createdAt = $data['created_at'];
                foreach ($data['payload']['commits'] as $commitRaw) {
                    $message = json_encode([
                        'sha' => $commitRaw['sha'],
                        'message' => $commitRaw['message'],
                        'created_at' => $createdAt,
                    ]);
                    $this->producer->send($message);
                    yield ++$i;
                }
            }
        }
    }
}