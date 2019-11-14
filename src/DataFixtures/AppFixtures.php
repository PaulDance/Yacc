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
		$idfRegion = (new Region())
						->setCountry("FR")
						->setName("Île-de-France")
						->setPresentation("La région française capitale.");
		$manager->persist($idfRegion);
		
		$manager->flush();
		// Une fois l'instance de Region sauvée en base de données,
		// elle dispose d'un identifiant généré par Doctrine, et peut
		// donc être sauvegardée comme future référence.
		$this->addReference(self::IDF_REGION_REFERENCE, $idfRegion);
		
		$jeanMichelOwner = (new Owner())
								->setFirstName("Jean-Michel")
								->setLastName("Fermier")
								->setCountry("FR")
								->setAddress("3 hameau de Bouzole");
		$manager->persist($jeanMichelOwner);
		
		$jmRoom1 = (new Room())
						->setSummary("Beau poulailler ancien à Évry")
						->setDescription("Très joli espace sur paille")
						->setCapacity(15)
						->setArea(5.0)
						->setPrice(10.0)
						->setAddress("4 hameau de Bouzole")
						->setOwner($jeanMichelOwner)
		// $room->addRegion($region);
						->addRegion($this->getReference(self::IDF_REGION_REFERENCE));
		$manager->persist($jmRoom1);
		
		$geoffroyZardiClient = (new Client())
									->setFirstName("Geoffroy")
									->setLastName("Zardi")
									->setEmail("geoffroy.zardi@telecom-sudparis.eu");
		$manager->persist($geoffroyZardiClient);
		
		$gzJmRoom1Comment1 = (new Comment())
									->setText("Un certain charme rustique.")
									->setGrade(3)
									->setDateTime((new \DateTime())
														->setDate(2019, 10, 23)
														->setTime(19, 46, 17))
									->setRoom($jmRoom1)
									->setClient($geoffroyZardiClient);
		$manager->persist($gzJmRoom1Comment1);
		
		$manager->flush();
	}
}