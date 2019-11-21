<?php

namespace App\Repository;

use App\Entity\ImageAsset;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


/**
 * @method ImageAsset|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageAsset|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageAsset[] findAll()
 * @method ImageAsset[] findBy(array $criteria, array $orderBy = null, $limit = null,
 *         $offset = null)
 */
class ImageAssetRepository extends ServiceEntityRepository {
	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, ImageAsset::class);
	}
}
