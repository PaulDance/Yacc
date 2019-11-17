<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Region;
use App\Entity\Room;
use App\Entity\Owner;
use App\Entity\Client;
use App\Entity\Comment;
use App\Entity\Reservation;
use App\Entity\UserAccount;


class AppFixtures extends Fixture {
	// définit un nom de référence pour une instance de Region
	public const IDF_REGION_REFERENCE = 'idf-region';
	
	public function load(ObjectManager $manager) {
		$idfRegion = (new Region())
						->setCountry('FR')
						->setName('Île-de-France')
						->setPresentation('La région française capitale.');
		$manager->persist($idfRegion);
		
		$manager->flush();
		// Une fois l'instance de Region sauvée en base de données,
		// elle dispose d'un identifiant généré par Doctrine, et peut
		// donc être sauvegardée comme future référence.
		$this->addReference(self::IDF_REGION_REFERENCE, $idfRegion);
		
		
		$jeanMichelOwner = (new Owner())
								->setUserAccount((new UserAccount())
														->setEmail('jm-du-28@club-internet.fr')
														->setFirstName('Jean-Michel')
														->setLastName('Fermier')
														->setPassword('gertrude'))
								->setCountry('FR')
								->setAddress('3 hameau de Bouzole');
		$manager->persist($jeanMichelOwner);
		
		$jmRoom1 = (new Room())
						->setSummary('Beau poulailler ancien à Évry')
						->setDescription('Très joli espace sur paille.')
						->setCapacity(15)
						->setArea(5.0)
						->setPrice(10.0)
						->setAddress('4 hameau de Bouzole')
						->setOwner($jeanMichelOwner)
						->addRegion($this->getReference(self::IDF_REGION_REFERENCE));
		$manager->persist($jmRoom1);
		
		$jmRoom2 = (new Room())
						->setSummary('Belle chambre spacieuse à Évry')
						->setDescription('Vue sur poulailler ancien.')
						->setCapacity(4)
						->setArea(40.0)
						->setPrice(70.0)
						->setAddress('6 hameau de Bouzole')
						->setOwner($jeanMichelOwner)
						->addRegion($this->getReference(self::IDF_REGION_REFERENCE));
		$manager->persist($jmRoom2);
		
		
		$geoffroyZardiClient = (new Client())
									->setUserAccount((new UserAccount())
															->setEmail('geoffroy.zardi@telecom-sudparis.eu')
															->setFirstName('Geoffroy')
															->setLastName('Zardi')
															->setPassword('gzpasswd'));
		$manager->persist($geoffroyZardiClient);
		
		$gzJmRoom1Comment1 = (new Comment())
									->setText('Un certain charme rustique.')
									->setGrade(3)
									->setDateTime((new \DateTime())
														->setDate(2019, 10, 23)
														->setTime(19, 46, 17))
									->setRoom($jmRoom1)
									->setClient($geoffroyZardiClient);
		$manager->persist($gzJmRoom1Comment1);
		
		$gzJmRoom1Reservation = (new Reservation())
										->setStartDate((new \DateTime())->setDate(2019, 11, 28))
										->setEndDate((new \DateTime())->setDate(2019, 12, 02))
										->setClient($geoffroyZardiClient)
										->addRoom($jmRoom1);
		$manager->persist($gzJmRoom1Reservation);
		
		
		$alexisLeGlaunecClient = (new Client())
										->setUserAccount((new UserAccount())
												->setEmail('alexis.le_glaunec@telecom-sudparis.eu')
												->setFirstName('Alexis')
												->setLastName('Le Glaunec')
												->setPassword('algpasswd'));
		$manager->persist($alexisLeGlaunecClient);
		
		$algJmRoom1Reservation = (new Reservation())
										->setStartDate((new \DateTime())->setDate(2019, 11, 17))
										->setEndDate((new \DateTime())->setDate(2019, 11, 23))
										->setClient($alexisLeGlaunecClient)
										->addRoom($jmRoom1)
										->addRoom($jmRoom2);
		$manager->persist($algJmRoom1Reservation);
		
		
		$manager->flush();
	}
}