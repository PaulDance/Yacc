<?php

namespace App\Repository;

use App\Entity\Room;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Types\Types;


/**
 * @method Room|null find($id, $lockMode = null, $lockVersion = null)
 * @method Room|null findOneBy(array $criteria, array $orderBy = null)
 * @method Room[] findAll()
 * @method Room[] findBy(array $criteria, array $orderBy = null, $limit = null,
 *			$offset = null)
 */
class RoomRepository extends ServiceEntityRepository {
	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, Room::class);
	}
	
	/**
	 * Performs a search for rooms of the database using multiple elements.
	 * 
	 * @param string $roomSearch A string to look for in the rooms' summaries
	 * 			and longer description.
	 * @param string $regionSearch A string to look for in the rooms' regions'
	 * 			names and longer presentation.
	 * @return array The array of found {@see Room} objects
	 */
	public function findBySearch(string $roomSearch, string $regionSearch): array {
		$qb = $this->createQueryBuilder('room');
		
		$qb->join('room.regions', 'region')
			->where($qb->expr()->andX(
							$qb->expr()->orX(
								$qb->expr()->like($qb->expr()->lower('room.summary'),
													$qb->expr()->lower(':roomSearchPattern')),
								$qb->expr()->like($qb->expr()->lower('room.description'),
													$qb->expr()->lower(':roomSearchPattern'))),
							$qb->expr()->orX(
								$qb->expr()->like($qb->expr()->lower('region.name'),
													$qb->expr()->lower(':regionSearchPattern')),
								$qb->expr()->like($qb->expr()->lower('region.presentation'),
													$qb->expr()->lower(':regionSearchPattern')))))
			->distinct()
			->setParameter('roomSearchPattern', "%$roomSearch%", Types::STRING)
			->setParameter('regionSearchPattern', "%$regionSearch%", Types::STRING);
		
		return $qb->getQuery()->execute();
	}
}
