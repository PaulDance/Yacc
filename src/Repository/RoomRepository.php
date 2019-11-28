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
	 * Utility that generates a random array of $quantity
	 * integers ranging between $min and $max.
	 *  
	 * @param int $min The minimal value of the range.
	 * @param int $max The maximal value of the range.
	 * @param int $quantity The length of the array to generate.
	 * @return array The generated array of integers.
	 */
	public static function randomRangedArray(int $min, int $max, int $quantity): array {
		$numbers = range($min, $max);
		shuffle($numbers);
		
		return array_slice($numbers, 0, $quantity);
	}
	
	/**
	 * @return int The number of Room objects in the database.
	 */
	public function getCount(): int {
		$qb = $this->getEntityManager()->createQueryBuilder();
		
		return $qb->select($qb->expr()->count('room.id'))
					->from(Room::class, 'room')
					->getQuery()
					->getSingleScalarResult();
	}
	
	/**
	 * Produces an array containing a specifiable number of
	 * Room objects from the database.
	 * 
	 * @param int $numberOfRooms The wanted array size.
	 * @return array The generated array of Rooms.
	 */
	public function getRandom(int $numberOfRooms): array {
		$qb = $this->createQueryBuilder('room');
		
		return $qb->where($qb->expr()->in('room.id',
								RoomRepository::randomRangedArray(1,
																$this->getCount(),
																$numberOfRooms)))
					->getQuery()
					->execute();
	}
	
	/**
	 * Performs a search for rooms of the database using multiple elements.
	 * 
	 * @param string $roomSearch A string to look for in the rooms' summaries
	 * 			and longer description.
	 * @param string $regionSearch A string to look for in the rooms' regions'
	 * 			names and longer presentation.
	 * @param string $minPriceSearch A string representing a number that will
	 * 			be less than any of the selected room prices.
	 * @param string $maxPriceSearch A string representing a number that will
	 * 			be greater than any of the selected room prices.
	 * @return array The array of found {@see Room} objects
	 */
	public function findBySearch(string $roomSearch,
								string $regionSearch,
								string $startDateSearch,
								string $endDateSearch,
								string $minPriceSearch,
								string $maxPriceSearch): array {
		$qb = $this->createQueryBuilder('room');
		$eb = $qb->expr();
		
		$qb->distinct()
			->join('room.regions', 'region')
			->andWhere($eb->orX(
							$eb->like($eb->concat('room.summaryLowercase', 'room.descriptionLowercase'),
										':roomSearchPattern'),
							$eb->like($eb->concat('room.descriptionLowercase', 'room.summaryLowercase'),
										':roomSearchPattern')))
			->andWhere($eb->orX(
							$eb->like($eb->concat('region.nameLowercase', 'region.presentationLowercase'),
										':regionSearchPattern'),
							$eb->like($eb->concat('region.presentationLowercase', 'region.nameLowercase'),
										':regionSearchPattern')))
			->andWhere($eb->notIn('room.id', $this->createQueryBuilder('subRoom')
							->select('subRoom.id')
							->join('subRoom.reservations', 'reservation')
							->where($eb->andX(
										$eb->lt('reservation.startDate', ':endDateSearch'),
										$eb->lt(':startDateSearch', 'reservation.endDate')))
							->getDQL()))
			->andWhere($eb->between('room.price', ':minPriceSearch', ':maxPriceSearch'))
			->setParameter('roomSearchPattern', '%' . mb_strtolower(str_replace(' ', '%', $roomSearch)) . '%', Types::STRING)
			->setParameter('regionSearchPattern', '%' . mb_strtolower(str_replace(' ', '%', $regionSearch)) . '%', Types::STRING)
			->setParameter('startDateSearch', \DateTime::createFromFormat('d#m#Y', $startDateSearch)->format('Y-m-d'), Types::STRING)
			->setParameter('endDateSearch', \DateTime::createFromFormat('d#m#Y', $endDateSearch)->format('Y-m-d'), Types::STRING)
			->setParameter('minPriceSearch', $minPriceSearch, Types::STRING)
			->setParameter('maxPriceSearch', $maxPriceSearch, Types::STRING);
		
		return $qb->getQuery()->execute();
	}
	
	/**
	 * Queries the database in order to find the lowest room
	 * price available without any sort of restrictive criteria.
	 * 
	 * @return float The minimum price value.
	 */
	public function findMinPrice(): float {
		$qb = $this->getEntityManager()->createQueryBuilder();
		
		$qb->select($qb->expr()->min('room.price'))
			->from(Room::class, 'room');
		
		return floatval($qb->getQuery()->execute()[0][1]);
	}
	
	/**
	 * Queries the database in order to find the highest room
	 * price available without any sort of restrictive criteria.
	 *
	 * @return float The maximum price value.
	 */
	public function findMaxPrice(): float {
		$qb = $this->getEntityManager()->createQueryBuilder();
		
		$qb->select($qb->expr()->max('room.price'))
			->from(Room::class, 'room');
		
		return floatval($qb->getQuery()->execute()[0][1]);
	}
	
	/**
	 * Queries the database in order to find both the lowest
	 * and highest room prices available at the same time,
	 * without any sort of restrictive criteria.
	 * 
	 * @return array A map array in which 'minPrice' will be
	 *			associated with the minimum value as a float
	 *			and 'maxPrice' with the maximum one, a float
	 *			as well.
	 */
	public function findMinMaxPrices(): array {
		$qb = $this->getEntityManager()->createQueryBuilder();
		$eb = $qb->expr();
		
		$qb->select($eb->min('room.price'), $eb->max('room.price'))
			->from(Room::class, 'room');
		
		$minMaxStringPrices = $qb->getQuery()->execute()[0];
		return ['minPrice' => floatval($minMaxStringPrices[1]),
				'maxPrice' => floatval($minMaxStringPrices[2])];
	}
}
