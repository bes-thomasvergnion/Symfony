<?php

namespace TV\UserBundle\Repository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class BandRepository extends \Doctrine\ORM\EntityRepository
{
    public function getBands($page, $nbPerPage)
    {
        $query = $this->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->getQuery()
        ;

        $query
            ->setFirstResult(($page-1) * $nbPerPage)
            ->setMaxResults($nbPerPage)
          ;
        return new Paginator($query, true);
    }
    
    public function getBandsWithFilters(\TV\FindyourbandBundle\Entity\Search $search, $page, $nbPerPage)
    {
        $query = $this->createQueryBuilder('g');
        $andX = $query->expr()->andX();

        if(null !== $search->getProvince()){
            $andX->add('g.province = :province');
            $query->setParameter('province', $search->getProvince());
        }
        if(null !== $search->getGenre()){
            $andX->add('g.genre = :genre');
            $query->setParameter('genre', $search->getGenre());
        }
        if(null !== $search->getLevel()){
            $andX->add('g.level = :level');
            $query->setParameter('level', $search->getLevel());
        }
        if(!empty($search->getInstrument()) || !empty($search->getLevel()) || !empty($search->getGenre()) || !empty($search->getProvince())){
            $query->where($andX);
        }
        $query->orderBy('g.date', 'DESC');
        
        $query
            ->setFirstResult(($page-1) * $nbPerPage)
            ->setMaxResults($nbPerPage)
          ;
        return new Paginator($query, true);
    }
    
    public function findFull($id){
        $qb = $this->createQueryBuilder('b');
        $qb->leftJoin('b.users', 'u')
                ->addSelect('u')
                ->where('b.id=:id')
                ->setParameter('id', $id)
                ;
        
        return $qb->getQuery()->getOneOrNullResult();
    }
    
    public function getBandsHome()
    {
        $query = $this->createQueryBuilder('a')
            ->orderBy('a.date', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
        ;

        return $query->getResult();
    }
    
    public function getBandsAdmin()
    {
        $query = $this->createQueryBuilder('a')
            ->orderBy('a.date', 'DESC')
            ->setMaxResults(20)
            ->getQuery()
        ;

        return $query->getResult();
    }
    
    public function getLikeQueryBuilder($user, \TV\UserBundle\Entity\User $receiver)
    {
        $bandsId = array_map(function(\TV\UserBundle\Entity\Band $band){return $band->getId();},$receiver->getBands()->toArray());
        $qb= $this
        ->createQueryBuilder('c');
        $qb
        ->where('c.administrator = :user')
        ->setParameter('user', $user)
            ->andWhere($qb->expr()->notIn('c.id', $bandsId))
        ;
        return $qb;
    }
}
