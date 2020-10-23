<?php

namespace Shared;

class Commit
{
    private string $sha;
    private string $message;
    private \DateTimeImmutable $createdAt;

    public function __construct(string $sha, string $message, \DateTimeImmutable $createdAt)
    {
        $this->sha = $sha;
        $this->message = $message;
        $this->createdAt = $createdAt;
    }

    public function getSha(): string
    {
        return $this->sha;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}