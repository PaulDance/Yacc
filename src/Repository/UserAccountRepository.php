<?php

namespace App\Repository;

use App\Entity\UserAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


/**
 * @method UserAccount|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserAccount|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserAccount[] findAll()
 * @method UserAccount[] findBy(array $criteria, array $orderBy = null, $limit =
 *         null, $offset = null)
 */
class UserAccountRepository extends ServiceEntityRepository {
	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, UserAccount::class);
	}
}
