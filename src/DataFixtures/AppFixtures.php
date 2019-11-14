<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Region;
use App\Entity\Room;
use App\Entity\Owner;
use App\Entity\Client;
use App\Entity\Comment;


class AppFixtures extends Fixture {
	// définit un nom de référence pour une instance de Region
	public const IDF_REGION_REFERENCE = 'idf-region';
	
	public function load(ObjectManager $manager) {
		$idfRegion = new Region();
		$idfRegion->setCountry("FR");
		$idfRegion->setName("Île-de-France");
		$idfRegion->setPresentation("La région française capitale.");
		$manager->persist($idfRegion);
		
		$manager->flush();
		// Une fois l'instance de Region sauvée en base de données,
		// elle dispose d'un identifiant généré par Doctrine, et peut
		// donc être sauvegardée comme future référence.
		$this->addReference(self::IDF_REGION_REFERENCE, $idfRegion);
		
		$jeanMichelOwner = new Owner();
		$jeanMichelOwner->setFirstName("Jean-Michel");
		$jeanMichelOwner->setLastName("Fermier");
		$jeanMichelOwner->setCountry("FR");
		$jeanMichelOwner->setAddress("3 hameau de Bouzole");
		$manager->persist($jeanMichelOwner);
		
		$jmRoom1 = new Room();
		$jmRoom1->setSummary("Beau poulailler ancien à Évry");
		$jmRoom1->setDescription("Très joli espace sur paille");
		$jmRoom1->setCapacity(15);
		$jmRoom1->setArea(5.0);
		$jmRoom1->setPrice(10.0);
		$jmRoom1->setAddress("4 hameau de Bouzole");
		$jmRoom1->setOwner($jeanMichelOwner);
		// $room->addRegion($region);
		$jmRoom1->addRegion($this->getReference(self::IDF_REGION_REFERENCE));
		$manager->persist($jmRoom1);
		
		$geoffroyZardiClient = new Client();
		$geoffroyZardiClient->setFirstName("Geoffroy");
		$geoffroyZardiClient->setLastName("Zardi");
		$geoffroyZardiClient->setEmail("geoffroy.zardi@telecom-sudparis.eu");
		$manager->persist($geoffroyZardiClient);
		
		$gzJmRoom1Comment1 = new Comment();
		$gzJmRoom1Comment1->setText("Un certain charme rustique.");
		$gzJmRoom1Comment1->setGrade(3);
		$gzJmRoom1Comment1->setDateTime((new \DateTime())->setDate(2019, 10, 23)->setTime(19, 46, 17));
		$gzJmRoom1Comment1->setRoom($jmRoom1);
		$gzJmRoom1Comment1->setClient($geoffroyZardiClient);
		$manager->persist($gzJmRoom1Comment1);
		
		$manager->flush();
	}
}