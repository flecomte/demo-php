<?php

namespace Api\Repository;

use FLE\JsonHydrator\Repository\AbstractRepository;

class HistoryRepository extends AbstractRepository
{
    public function findAll(string $keyword, string $date): array
    {
        $stmt = $this->preparefunction('find_history', [
            'keyword' => $keyword,
            '_created_at' => $date,
        ]);

        return $stmt->fetchAsArray();
    }
}
