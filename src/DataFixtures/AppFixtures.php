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
		$region = new Region();
		$region->setCountry("FR");
		$region->setName("Île-de-France");
		$region->setPresentation("La région française capitale.");
		$manager->persist($region);
		
		$manager->flush();
		// Une fois l'instance de Region sauvée en base de données,
		// elle dispose d'un identifiant généré par Doctrine, et peut
		// donc être sauvegardée comme future référence.
		$this->addReference(self::IDF_REGION_REFERENCE, $region);
		
		$owner = new Owner();
		$owner->setFirstName("Jean-Michel");
		$owner->setLastName("Fermier");
		$owner->setCountry("FR");
		$owner->setAddress("3 hameau de Bouzole");
		$manager->persist($owner);
		
		$room = new Room();
		$room->setSummary("Beau poulailler ancien à Évry");
		$room->setDescription("Très joli espace sur paille");
		$room->setCapacity(15);
		$room->setArea(5.0);
		$room->setPrice(10.0);
		$room->setAddress("4 hameau de Bouzole");
		$room->setOwner($owner);
		// $room->addRegion($region);
		$room->addRegion($this->getReference(self::IDF_REGION_REFERENCE));
		$manager->persist($room);
		
		$client = new Client();
		$client->setFirstName("Geoffroy");
		$client->setLastName("Zardi");
		$client->setEmail("geoffroy.zardi@telecom-sudparis.eu");
		$manager->persist($client);
		
		$comment = new Comment();
		$comment->setText("Un certain charme rustique.");
		$comment->setGrade(3);
		$comment->setRoom($room);
		$comment->setClient($client);
		$manager->persist($comment);
		
		$manager->flush();
	}
}