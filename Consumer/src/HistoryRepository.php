<?php

namespace Consumer;

use FLE\JsonHydrator\Repository\AbstractRepository;

class HistoryRepository extends AbstractRepository
{
    public function insert(string $data): bool
    {
        $stmt = $this->preparefunction('insert_history', [
            'data' => $data,
        ]);

        return $stmt->execute();
    }
}