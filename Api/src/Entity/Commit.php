<?php

namespace Api\Entity;

use FLE\JsonHydrator\Entity\UuidEntityInterface;
use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\ExclusionPolicy("none")
 */
class Commit implements UuidEntityInterface
{
    /** @JMS\Expose() */
    private string $sha;
    private ?string $message;
    private ?\DateTimeImmutable $createdAt;

    public function __construct(string $sha, ?string $message, ?\DateTimeImmutable $createdAt)
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

    static function getReference($sha): UuidEntityInterface
    {
        return new self($sha, null, null);
    }

    public function getId(): ?string
    {
        return $this->getSha().'_'.$this->getCreatedAt()->format(\DateTime::W3C);
    }
}