<?php

namespace Application\Orm;

use \DateTime;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Doctrine\ORM\QueryBuilder;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;

use Zend\Paginator\Paginator;

/**
 * Basis-Repository für Entities
 */
class BaseRepository extends EntityRepository
{
    protected $entityName = ''; // zB Application\Entity\User
    protected $tableAlias = ''; // zB u
    protected $idField    = 'id';
    
    /**
     * Sucht Entities, gibt ein Array zurück
     * 
     * @param array $filters
     * @param integer $limit
     * @param integer $offset
     * @return array
     */
    public function findEntities($filters = array(), $limit = 0, $offset = 0)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select($this->tableAlias)
           ->from($this->entityName, $this->tableAlias);
        
        $this->handleFilters($qb, $filters);
        
        return $qb->getQuery()->getResult();
    }
    
    /**
    * Sucht Entities, gibt aber das Resultat als Paginator zurück
    * 
    * @param array $filters
    * @param integer $itemsPerPage
    * @return \Zend\Paginator\Paginator
    */
    public function getPaginator($filters = array(), $itemsPerPage = 25)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select($this->tableAlias)
           ->from($this->entityName, $this->tableAlias);
        
        $this->handleFilters($qb, $filters);
        
        $adapter = new DoctrineAdapter(new ORMPaginator($qb));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage($itemsPerPage);
        
        return $paginator;
    }
    
    /**
     * Zählt Entities
     *
     * @param array $filters
     * @return integer
     */
    public function countEntities($filters = array())
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('COUNT(' . $this->tableAlias . '.' . $this->idField . ')')
           ->from($this->entityName, $this->tableAlias);
        
        $this->handleFilters($qb, $filters, true);
        
        $count = $qb->getQuery()->getSingleScalarResult();
        
        return $count;
    }
    
    /**
     * Fügt einen Join hinzu.
     * Falls es den Join schon gibt, wir er nicht nochmals hinzugefügt
     * 
     * @param QueryBuilder $qb
     * @param string $joinField
     * @param string $joinAlias
     * @param string $type not used yet
     */
    protected function addJoin($qb, $joinField, $joinAlias, $type = 'inner')
    {
        $joinParts = $qb->getDQLPart('join');
        if (array_key_exists($joinAlias, $joinParts)) {
            return;
        }
        foreach ($joinParts as $joins) {
            foreach ($joins as $join) {
                if ($join->getAlias() == $joinAlias) {
                    return;
                }
            }
        }
        if ($type == 'inner') {
            $qb->innerJoin($joinField, $joinAlias);
        }
        if ($type == 'left') {
            $qb->leftJoin($joinField, $joinAlias);
        }
    }
    
    /**
    * Fügt den Query-Filter für bestimmte Felder hinzu ("name LIKE '%value%'")
    * 
    * @param QueryBuilder $qb
    * @param string $value
    * @param string $tableAlias
    * @param array $searchFields
    */
    protected function addQueryFilter($qb, $value, $tableAlias, $searchFields)
    {
        if ($value === null || $value === '') {
            return;
        }
        
        if (is_numeric($value)) {
            $qb->andWhere(
                $qb->expr()->eq($tableAlias . '.id', ':id')
            );
            $qb->setParameter('id', $value);
            return;
        }
        
        $phrases = array();
        foreach ($searchFields as $field) {
            $phrases[] = $qb->expr()->like($tableAlias . '.' . $field, ':searchPhrase');
        }
        $qb->andWhere(
            call_user_func_array(array($qb->expr(), 'orX'), $phrases)
        );
        $qb->setParameter('searchPhrase', '%' . $value . '%');
    }
}
