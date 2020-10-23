<?php

namespace Consumer;

use FLE\JsonHydrator\Repository\AbstractRepository;

class CommitRepository extends AbstractRepository
{
    public function insert(string $data): bool
    {
        $stmt = $this->preparefunction('insert_commit', [
            'data' => $data,
        ]);

        return $stmt->execute();
    }
}