<?php

namespace Consumer;

use FLE\JsonHydrator\Repository\AbstractRepository;

class HistoryRepository extends AbstractRepository
{
    public function findAll(string $keyword, string $date): array
    {
        $stmt = $this->preparefunction('find_history', [
            'keyword' => $keyword,
            'date' => $date,
        ]);

        return $stmt->fetchAsArray();
    }

    public function insert(string $data): bool
    {
        $stmt = $this->preparefunction('insert_history', [
            'data' => $data,
        ]);

        return $stmt->execute();
    }
}