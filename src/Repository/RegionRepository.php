<?php

namespace App\Repository;

use App\Entity\Region;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


/**
 * @method Region|null find($id, $lockMode = null, $lockVersion = null)
 * @method Region|null findOneBy(array $criteria, array $orderBy = null)
 * @method Region[] findAll()
 * @method Region[] findBy(array $criteria, array $orderBy = null, $limit = null,
 *         $offset = null)
 */
class RegionRepository extends ServiceEntityRepository {
	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, Region::class);
	}
	
	/**
	 * @return int The number of Region objects in the database.
	 */
	public function getCount(): int {
		$qb = $this->getEntityManager()->createQueryBuilder();
		
		return $qb->select($qb->expr()->count('region.id'))
					->from(Region::class, 'region')
					->getQuery()
					->getSingleScalarResult();
	}
	
	/**
	 * Produces an array containing a specifiable number of
	 * Region objects from the database.
	 * 
	 * @param int $numberOfRegions The wanted array size.
	 * @return array The generated array of Regions.
	 */
	public function getRandom(int $numberOfRegions): array {
		$qb = $this->createQueryBuilder('region');
		
		return $qb->where($qb->expr()->in('region.id',
								RoomRepository::randomRangedArray(1,
																$this->getCount(),
																$numberOfRegions)))
					->getQuery()
					->execute();
	}
}
