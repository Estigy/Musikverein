<?php

namespace Members\Repository;

use \DateTime;

use Application\Orm\BaseRepository;
use Application\Orm\SimplePaginator;

use Doctrine\ORM\QueryBuilder;

/**
 * Repository-Klasse für Medal
 */
class Medal extends BaseRepository
{
    protected $entityName = 'Members\Entity\Medal';
    protected $tableAlias = 'm';
    
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
                case 'namesearch':
                    $this->addQueryFilter($qb, $value, 'w', array('name'));
                    break;
            }
        }
        
        if (!$countMode) {
            if (!empty($filters['order'])) {
                $this->addOrderBy($qb, $filters['order'], 'w');
            }
            // Standard-Sortierung
            if (!count($qb->getDQLPart('orderBy'))) {
                $qb->addOrderBy('m.sorting', 'ASC');
            }
        }
        
        //echo $qb->getQuery()->getSQL();
        //echo $qb->getDQL();
        //die();        
    }
}
