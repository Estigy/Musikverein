<?php

namespace Bmk\Repository;

use \DateTime;

use Application\Orm\BaseRepository;
use Application\Orm\SimplePaginator;

use Doctrine\ORM\QueryBuilder;

/**
 * Repository-Klasse für Register
 */
class Register extends BaseRepository
{
    protected $entityName = 'Bmk\Entity\Register';
    protected $tableAlias = 'r';

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
                case 'getForInstruments':
                    $qb->andWhere(
                        $qb->expr()->neq('r.sortingForInstruments', -1)
                    );
                    $qb->addOrderBy('r.sortingForInstruments', 'ASC');
                    break;
                case 'getForAttendance':
                    $qb->andWhere(
                        $qb->expr()->neq('r.sortingForAttendance', -1)
                    );
                    $qb->addOrderBy('r.sortingForAttendance', 'ASC');
                    break;
            }
        }

        if (!$countMode) {
            if (!empty($filters['order'])) {
                $this->addOrderBy($qb, $filters['order'], 'r');
            }
            // Standard-Sortierung
            if (!count($qb->getDQLPart('orderBy'))) {
                $qb->addOrderBy('r.name', 'ASC');
            }
        }

        //echo $qb->getQuery()->getSQL();
        //echo $qb->getDQL();
        //die();
    }
}
