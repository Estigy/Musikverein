<?php

namespace Sheetmusic\Repository;

use \DateTime;

use Application\Orm\BaseRepository;
use Application\Orm\SimplePaginator;

use Doctrine\ORM\QueryBuilder;

/**
 * Repository-Klasse für Piece
 */
class Piece extends BaseRepository
{
    protected $entityName = 'Sheetmusic\Entity\Piece';
    protected $tableAlias = 'p';
    
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
                case 'title':
                case 'publisher':
                    $this->addQueryFilter($qb, $value, 'p', array($clause));
                    break;
                case 'composer-arranger':
                    $this->addQueryFilter($qb, $value, 'p', array('composer', 'arranger'));
                    break;
                case 'genre':
                case 'isAway':
                case 'isScanned':
                    $qb->andWhere(
                        $qb->expr()->eq('p.' . $clause, ':' . $clause)
                    );
                    $qb->setParameter($clause, $value);
                    break;
            }
        }
        
        if (!$countMode) {
            if (!empty($filters['order'])) {
                $qb->addOrderBy('p.' . $filters['order'], 'ASC');
            }
            // Standard-Sortierung
            if (!count($qb->getDQLPart('orderBy'))) {
                $qb->addOrderBy('p.title', 'ASC');
            }
        }
        
        //echo $qb->getQuery()->getSQL();
        //echo $qb->getDQL();
        //die();        
    }
}
