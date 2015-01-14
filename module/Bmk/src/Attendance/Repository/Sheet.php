<?php

namespace Attendance\Repository;

use \DateTime;

use Application\Orm\BaseRepository;
use Application\Orm\SimplePaginator;

use Doctrine\ORM\QueryBuilder;

/**
 * Repository-Klasse für Sheet
 */
class Sheet extends BaseRepository
{
    protected $entityName = 'Attendance\Entity\Sheet';
    protected $tableAlias = 's';

    /**
     * Integriert die Filter in den QueryBuilder
     *
     * @param QueryBuilder $qb
     * @param array $filters
     * @param boolean $countMode When doing a COUNT(), some things need not be done (like adding ORDER BY clauses)
     * @throws BadRequestException
     */
    protected function handleFilters(QueryBuilder $qb, array $filters, $countMode = false)
    {
        foreach ($filters as $clause => $value) {
            if ($value === null) {
                continue;
            }
            switch ($clause) {
                case 'band':
                case 'year':
                    $qb->andWhere(
                        $qb->expr()->eq('i.' . $clause, ':' . $clause)
                    );
                    $qb->setParameter($clause, $value);
                    break;
            }
        }

        if (!$countMode) {
            if (!empty($filters['order'])) {
                $this->addOrderBy($qb, $filters['order'], 'w');
            }
            // Standard-Sortierung
            if (!count($qb->getDQLPart('orderBy'))) {
                $qb->addOrderBy('s.year', 'DESC');
                $qb->addOrderBy('s.band', 'ASC');
                $qb->addOrderBy('s.name', 'ASC');
            }
        }

        //echo $qb->getQuery()->getSQL();
        //echo $qb->getDQL();
        //die();
    }
}
