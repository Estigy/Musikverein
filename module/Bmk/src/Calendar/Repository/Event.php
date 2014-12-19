<?php

namespace Calendar\Repository;

use \DateTime;

use Application\Orm\BaseRepository;
use Application\Orm\SimplePaginator;

use Doctrine\ORM\QueryBuilder;

/**
 * Repository-Klasse für Event
 */
class Event extends BaseRepository
{
    protected $entityName = 'Calendar\Entity\Event';
    protected $tableAlias = 'e';
    
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
                case 'status':
                case 'type':
                    $this->addQueryFilter($qb, $value, 'e', array($clause));
                    break;
                case 'year':
                    $value = (int) $value;
                    $qb->andWhere(
                        $qb->expr()->like('e.date', $qb->expr()->literal($value . '-%'))
                    );
                    break;
                case 'band':
                    $qb->andWhere(
                        $qb->expr()->like('e.band', $qb->expr()->literal('%"' . $value . '"%'))
                    );
                    break;
            }
        }
        
        if (!$countMode) {
            if (!empty($filters['order'])) {
                $this->addOrderBy($qb, $filters['order'], 'e');
            }
            // Standard-Sortierung
            if (!count($qb->getDQLPart('orderBy'))) {
                $qb->addOrderBy('e.date', 'ASC');
            }
        }
        
        //echo $qb->getQuery()->getSQL();
        //echo $qb->getDQL();
        //die();        
    }
    
    public function getDistinctYears()
    {
        return array(
        );
    }
}
