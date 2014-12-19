<?php

namespace Members\Repository;

use \DateTime;

use Application\Orm\BaseRepository;
use Application\Orm\SimplePaginator;

use Doctrine\ORM\QueryBuilder;

/**
 * Repository-Klasse für Member
 */
class Member extends BaseRepository
{
    protected $entityName = 'Members\Entity\Member';
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
                    $this->addQueryFilter($qb, $value, 'm', array('firstname', 'lastname'));
                    break;
                case 'status':
                    $qb->andWhere(
                        $qb->expr()->eq('i.' . $clause, ':' . $clause)
                    );
                    $qb->setParameter($clause, $value);
                    break;
            }
        }
        
        if (!$countMode) {
            if (!empty($filters['order'])) {
                $this->addOrderBy($qb, $filters['order'], 'm');
            }
            // Standard-Sortierung
            if (!count($qb->getDQLPart('orderBy'))) {
                $qb->addOrderBy('m.lastname', 'ASC')
                   ->addOrderBy('m.firstname', 'ASC');
            }
        }
        
        //echo $qb->getQuery()->getSQL();
        //echo $qb->getDQL();
        //die();        
    }
}
