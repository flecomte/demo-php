<?php

namespace Api\Repository;

use Api\Entity\Commit;
use FLE\JsonHydrator\Repository\AbstractRepository;

class CommitRepository extends AbstractRepository
{
    /**
     * @return Commit[]
     */
    public function findAll(string $date, ?string $keyword = null): array
    {
        $stmt = $this->preparefunction('find_commit', [
            'keyword' => $keyword,
            '_created_at' => $date,
        ]);

        return $stmt->fetchEntities(Commit::class);
    }
}
