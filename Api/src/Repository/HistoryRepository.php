<?php

namespace Api\Repository;

use FLE\JsonHydrator\Repository\AbstractRepository;

class HistoryRepository extends AbstractRepository
{
    public function findAll(string $date, ?string $keyword = null): array
    {
        $stmt = $this->preparefunction('find_history', [
            'keyword' => $keyword,
            '_created_at' => $date,
        ]);

        return $stmt->fetchAsArray();
    }
}
