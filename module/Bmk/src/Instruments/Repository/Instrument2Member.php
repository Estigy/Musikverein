<?php

namespace Instruments\Repository;

use \DateTime;

use Application\Orm\BaseRepository;
use Application\Orm\SimplePaginator;

use Doctrine\ORM\QueryBuilder;

/**
 * Repository-Klasse für Instrument2Member
 */
class Instrument2Member extends BaseRepository
{
    protected $entityName = 'Instruments\Entity\Instrument2Member';
    protected $tableAlias = 'i2m';
    
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
                case 'member':
                case 'instrument':
                    $qb->andWhere(
                        $qb->expr()->eq('i2m.' . $clause, ':' . $clause)
                    );
                    $qb->setParameter($clause, $value);
                    break;
                case 'currentOwner':
                    $qb->andWhere(
                        $qb->expr()->isNull('i2m.takeBackDate')
                    );
                    break;
            }
        }
        
        if (!$countMode) {
            if (!empty($filters['order'])) {
                $this->addOrderBy($qb, $filters['order'], 'i2m');
            }
            // Standard-Sortierung
            if (!count($qb->getDQLPart('orderBy'))) {
                $qb->addOrderBy('i2m.giveAwayDate', 'DESC');
            }
        }
        
        //echo $qb->getQuery()->getSQL();
        //echo $qb->getDQL();
        //die();        
    }
}
