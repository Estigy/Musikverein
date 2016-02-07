<?php

namespace Attendance\Repository;

use Attendance\Entity\Entry;
use \DateTime;

use Application\Orm\BaseRepository;
use Application\Orm\SimplePaginator;

use Doctrine\ORM\Query\ResultSetMapping;
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

    public function getRankingResult($sheetIds)
    {
        $rsm = new ResultSetMapping();

        $rsm->addEntityResult('Members\Entity\Member', 'm');
        $rsm->addFieldResult('m', 'id', 'id');
        $rsm->addFieldResult('m', 'firstname', 'firstname');
        $rsm->addFieldResult('m', 'lastname', 'lastname');
        $rsm->addScalarResult('anzahl', 'anzahl', 'integer');

        $query = $this->_em->createNativeQuery(
            "SELECT m.id, m.firstname, m.lastname, COUNT(entries.id) as anzahl
            FROM `lt_anwesenheit_entries` as entries
            INNER JOIN `lt_anwesenheit_events` as events ON entries.id_event = events.id
            INNER JOIN `lt_mitglieder` as m ON entries.id_mitglied = m.id
            WHERE events.id_liste IN (:sheetIds)
            AND entries.status = :status
            GROUP BY entries.id_mitglied
            ORDER BY anzahl DESC", $rsm
        );

        $query->setParameter('sheetIds', $sheetIds);
        $query->setParameter('status', Entry::STATUS_PRESENT);

        return $query->getResult();
    }
}
