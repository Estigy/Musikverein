<?php

namespace Members\Repository;

use \DateTime;

use Application\Orm\BaseRepository;
use Application\Orm\SimplePaginator;

use Doctrine\ORM\QueryBuilder;

/**
 * Repository-Klasse für Member2Band
 */
class Member2Band extends BaseRepository
{
    protected $entityName = 'Members\Entity\Member2Band';
    protected $tableAlias = 'm2b';

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
                case 'register':
                    $qb->andWhere(
                        $qb->expr()->eq('m2b.' . $clause, ':' . $clause)
                    );
                    $qb->setParameter($clause, $value);
                    break;
                case 'date':
                    $qb->andWhere(
                        $qb->expr()->orX(
                            $qb->expr()->between(':searchDate', 'm2b.beginDate', 'm2b.endDate'),
                            $qb->expr()->andX(
                                $qb->expr()->isNull('m2b.endDate'),
                                $qb->expr()->lte('m2b.beginDate', ':searchDate')
                            )
                        )
                    );
                    $qb->setParameter('searchDate', $value);
                    break;
            }
        }

        if (!$countMode) {
            if (!empty($filters['order'])) {
                $this->addOrderBy($qb, $filters['order'], 'm2b');
            }
            // Standard-Sortierung
            if (!count($qb->getDQLPart('orderBy'))) {
                //$qb->addOrderBy('m.lastname', 'ASC')
                //   ->addOrderBy('m.firstname', 'ASC');
            }
        }

        //echo $qb->getQuery()->getSQL();
        //echo $qb->getDQL();
        //die();
    }
}
