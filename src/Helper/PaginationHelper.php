<?php

namespace App\Helper;

use Doctrine\ORM\QueryBuilder;

class PaginationHelper
{
    public static function applyPagination(QueryBuilder $queryBuilder, ?array $pagination)
    {
        if(!empty($pagination['page']) && !empty($pagination['limit'])) {
            $queryBuilder->setMaxResults($pagination['limit'])
                ->setFirstResult(($pagination['page'] - 1) * $pagination['limit']);
        }

        return $queryBuilder;
    }
}
