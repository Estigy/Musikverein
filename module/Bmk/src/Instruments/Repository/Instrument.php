<?php

namespace Instruments\Repository;

use \DateTime;

use Application\Orm\BaseRepository;
use Application\Orm\SimplePaginator;

use Instruments\Entity\Instrument as InstrumentEntity;

use Doctrine\ORM\QueryBuilder;

/**
 * Repository-Klasse für Instrument
 */
class Instrument extends BaseRepository
{
    protected $entityName = 'Instruments\Entity\Instrument';
    protected $tableAlias = 'i';
    
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
                case 'serialsearch':
                    $this->addQueryFilter($qb, $value, 'i', array('serialNumber'));
                    break;
                case 'status':
                    if ($value == 'active') {
                        $qb->andWhere(
                            $qb->expr()->in('i.status', array(InstrumentEntity::STATUS_IN_ARCHIVE, InstrumentEntity::STATUS_GIVEN_AWAY))
                        );
                    } else {
                        $qb->andWhere(
                            $qb->expr()->eq('i.' . $clause, ':' . $clause)
                        );
                        $qb->setParameter($clause, $value);
                    }
                    break;
                case 'category':
                    $qb->andWhere(
                        $qb->expr()->eq('i.' . $clause, ':' . $clause)
                    );
                    $qb->setParameter($clause, $value);
                    break;
            }
        }
        
        if (!$countMode) {
            if (!empty($filters['order'])) {
                $this->addOrderBy($qb, $filters['order'], 'i');
            }
            // Standard-Sortierung
            if (!count($qb->getDQLPart('orderBy'))) {
                $qb->addOrderBy('i.serialNumber', 'ASC');
            }
        }
        
        //echo $qb->getQuery()->getSQL();
        //echo $qb->getDQL();
        //die();
    }
}
