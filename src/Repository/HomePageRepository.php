<?php

namespace App\Repository;

use App\Entity\HomePage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


/**
 * @method HomePage|null find($id, $lockMode = null, $lockVersion = null)
 * @method HomePage|null findOneBy(array $criteria, array $orderBy = null)
 * @method HomePage[] findAll()
 * @method HomePage[] findBy(array $criteria, array $orderBy = null, $limit = null,
 *         $offset = null)
 */
class HomePageRepository extends ServiceEntityRepository {
	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, HomePage::class);
	}
	
	/**
	 * @return HomePage The only home page in the database.
	 */
	public function getHomePage(): HomePage {
		return $this->createQueryBuilder('homePage')
					->setMaxResults(1)
					->getQuery()
					->execute()[0];
	}
}
