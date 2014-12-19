<?php

namespace Documents\Repository;

use \DateTime;

use Application\Orm\BaseRepository;
use Application\Orm\SimplePaginator;

use Doctrine\ORM\QueryBuilder;

/**
 * Repository-Klasse für Document
 */
class Document extends BaseRepository
{
    protected $entityName = 'Documents\Entity\Document';
    protected $tableAlias = 'd';
    
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
                case 'name':
                case 'filename':
                    $this->addQueryFilter($qb, $value, 'd', array($clause));
                    break;
                case 'genre':
                case 'isAway':
                case 'isScanned':
                    $qb->andWhere(
                        $qb->expr()->eq('d.' . $clause, ':' . $clause)
                    );
                    $qb->setParameter($clause, $value);
                    break;
            }
        }
        
        if (!$countMode) {
            if (!empty($filters['order'])) {
                $this->addOrderBy($qb, $filters['order'], 'd');
            }
            // Standard-Sortierung
            if (!count($qb->getDQLPart('orderBy'))) {
                $qb->addOrderBy('d.uploadDate', 'DESC');
            }
        }
        
        //echo $qb->getQuery()->getSQL();
        //echo $qb->getDQL();
        //die();        
    }
}
