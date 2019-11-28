<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Region;
use App\Entity\Room;
use App\Entity\Owner;
use App\Entity\Client;
use App\Entity\Comment;
use App\Entity\Reservation;
use App\Entity\UserAccount;
use App\Service\FileUploader;
use App\Entity\ImageAsset;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Entity\HomePage;


class AppFixtures extends Fixture {
	private $passwordEncoder;
	private $fileUploader;
	private $container;
	
	public function __construct(UserPasswordEncoderInterface $passwordEncoder,
								FileUploader $fileUploader,
								ContainerInterface $container) {
		$this->passwordEncoder = $passwordEncoder;
		$this->fileUploader = $fileUploader;
		$this->container = $container;
	}
	
	public function load(ObjectManager $manager) {
		$idfRegion = (new Region())
						->setCountry('FR')
						->setName('Île-de-France')
						->setPresentation('La région française capitale.');
		$manager->persist($idfRegion);							// Making the region object persist
		$manager->flush();										// and flushing it to the db is required for the
		$idfRegion->addImageAsset((new ImageAsset())			// object to have a db id used for the images.
										->getSetFromURL('https://upload.wikimedia.org/wikipedia/commons/thumb/d/db/Champ_de_bl%C3%A9_'
															. 'Seine-et-Marne.jpg/1280px-Champ_de_bl%C3%A9_Seine-et-Marne.jpg',
														Region::imgDirRelConfig, Region::imgDirAbsConfig, $idfRegion,
														$this->container, $this->fileUploader))
				->addImageAsset((new ImageAsset())
										->getSetFromURL('https://upload.wikimedia.org/wikipedia/commons/thumb/e/ed/Bercy'
															. '%2C_Paris_01.jpg/1280px-Bercy%2C_Paris_01.jpg',
														Region::imgDirRelConfig, Region::imgDirAbsConfig, $idfRegion,
														$this->container, $this->fileUploader))
				->addImageAsset((new ImageAsset())
										->getSetFromURL('https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Gorges_de'
															. '_Franchard_7.JPG/1280px-Gorges_de_Franchard_7.JPG',
														Region::imgDirRelConfig, Region::imgDirAbsConfig, $idfRegion,
														$this->container, $this->fileUploader));
		
		$cvlRegion = (new Region())
						->setCountry('FR')
						->setName('Centre-Val De Loire')
						->setPresentation('Grande région vinicole connue surtout pour ses vins blancs tels que le Sancerre et le Pouilly-Fumé.');
		$manager->persist($cvlRegion);							// Making the region object persist
		$manager->flush();										// and flushing it to the db is required for the
		$cvlRegion->addImageAsset((new ImageAsset())			// object to have a db id used for the images.
										->getSetFromURL('https://gitesologne41.fr/wp-content/uploads/2017/10/paysage-sauvage-centre.jpg',
														Region::imgDirRelConfig, Region::imgDirAbsConfig, $cvlRegion,
														$this->container, $this->fileUploader))
				->addImageAsset((new ImageAsset())
										->getSetFromURL('https://france3-regions.francetvinfo.fr/centre-val-de-loire/sites/'
														. 'regions_france3/files/styles/top_big/public/assets/images/2015/05/05/guide_3.jpg?itok=B_XjiIkh',
														Region::imgDirRelConfig, Region::imgDirAbsConfig, $cvlRegion,
														$this->container, $this->fileUploader))
					->addImageAsset((new ImageAsset())
										->getSetFromURL('https://www.val-de-loire-41.com/wp-content/uploads/external/'
															. '147-chateau-chambord-cdt41-l.d.-600x360.jpg',
														Region::imgDirRelConfig, Region::imgDirAbsConfig, $cvlRegion,
														$this->container, $this->fileUploader));
		
		$normandyRegion = (new Region())
								->setCountry('FR')
								->setName('Normandie')
								->setPresentation('La Normandie est une région du nord de la France. Son littoral varié'
									. 'comprend des falaises de craie blanche et des têtes de pont de la Seconde Guerre mondiale,'
									.'dont Omaha Beach, site du célèbre débarquement du jour J. Au large de la côte se trouve l\'île'
									.'rocheuse du Mont-Saint-Michel, au sommet duquel s\'élève une abbaye gothique.');
		$manager->persist($normandyRegion);
		$manager->flush();
		$normandyRegion->addImageAsset((new ImageAsset())
											->getSetFromURL('https://www.photo-paysage.com/albums/bord_de_mer/etretat/'
																. 'normal_paysage-du-littoral-normand.jpg',
															Region::imgDirRelConfig, Region::imgDirAbsConfig, $normandyRegion,
															$this->container, $this->fileUploader))
						->addImageAsset((new ImageAsset())
											->getSetFromURL('https://www.camping-bellevue.com/wp-content/'
																. 'uploads/2018/01/IMG_4906-2-1024x683.jpg',
															Region::imgDirRelConfig, Region::imgDirAbsConfig, $normandyRegion,
															$this->container, $this->fileUploader));
		
		$brittanyRegion = (new Region())
								->setCountry('FR')
								->setName('Bretagne')
								->setPresentation('La Bretagne, une région située à l’extrême ouest de la France,'
							 						.'est une péninsule vallonnée qui s’avance dans l’océan Atlantique.');
		$manager->persist($brittanyRegion);
		$manager->flush();
		$brittanyRegion->addImageAsset((new ImageAsset())
											->getSetFromURL('https://images.ctfassets.net/gxwgulxyxxy1/6SrIcGWZEXxOU4rkRZZKfO/'
																.'fc400dde1f5fa80f31b4e18e2e6c7a83/luca-bravo-a-x96OSFHCM-'
																. 'unsplash.jpg?fm=jpg&fl=progressive&w=680',
															Region::imgDirRelConfig, Region::imgDirAbsConfig, $brittanyRegion,
															$this->container, $this->fileUploader))
						->addImageAsset((new ImageAsset())
											->getSetFromURL('https://images.ctfassets.net/gxwgulxyxxy1/1mDT4KLmXgz7Q356IOQ4mh/'
																.'d527aa901439861c339373e7c02a5682/yeun-elez-3519589_1920'
																. '.jpg?fm=jpg&fl=progressive&w=680',
															Region::imgDirRelConfig, Region::imgDirAbsConfig, $brittanyRegion,
															$this->container, $this->fileUploader));
						 
		$guianaRegion = (new Region())
								->setCountry('FR')
								->setName('Guyane')
								->setPresentation('La Guyane française est une région d\'outre-mer située sur la côte nord-est'
													.'de l\'Amérique du Sud, couverte en grande partie de forêt tropicale.');
		$manager->persist($guianaRegion);
		$manager->flush();
		$guianaRegion->addImageAsset((new ImageAsset())
											->getSetFromURL('https://resize-parismatch.lanmedia.fr/r/901,,forcex/img/var/news/'
																.'storage/images/paris-match/vivre/voyage/la-guyane-le-departement-'
																.'le-plus-dingue-de-france-1500371/af0i1202/24570452-1-fre-FR/AF0I1202.jpg',
															Region::imgDirRelConfig, Region::imgDirAbsConfig, $guianaRegion,
															$this->container, $this->fileUploader))
					->addImageAsset((new ImageAsset())
											->getSetFromURL('https://resize-parismatch.lanmedia.fr/r/901,,forcex/img/var/news/'
																. 'storage/images/paris-match/vivre/voyage/la-guyane-le-departement-'
																.'le-plus-dingue-de-france-1500371/af0i0463/24570332-1-fre-FR/AF0I0463.jpg',
															Region::imgDirRelConfig, Region::imgDirAbsConfig, $guianaRegion,
															$this->container, $this->fileUploader));
		
		
		$jeanMichelOwnerAccount = new UserAccount();
		$jeanMichelOwner = (new Owner())
								->setUserAccount($jeanMichelOwnerAccount
													->addRole('ROLE_OWNER')
													->setEmail('jm-du-28@club-internet.fr')
													->setFirstName('Jean-Michel')
													->setLastName('Fermier')
													->setPassword($this->passwordEncoder
																		->encodePassword($jeanMichelOwnerAccount,
																						'gertrude')))
								->setCountry('FR')
								->setAddress('3 hameau de Bouzole');
		$manager->persist($jeanMichelOwner);
		
		$thomasOwnerAccount = new UserAccount();
		$thomasOwner = (new Owner())
							->setUserAccount($thomasOwnerAccount
												->addRole('ROLE_OWNER')
												->setEmail('thomas@invest.fr')
												->setFirstName('Thomas')
												->setLastName('Frapier')
												->setPassword($this->passwordEncoder
																	->encodePassword($thomasOwnerAccount,
																					'gertrude-bis')))
							->setCountry('FR')
							->setAddress('1 rue de Lousier');
		$manager->persist($thomasOwner);
		
		$jmRoom1 = (new Room())
						->setSummary('Beau poulailler ancien à Évry')
						->setDescription('Très joli espace sur paille.')
						->setCapacity(15)
						->setArea(5.0)
						->setPrice(10.0)
						->setAddress('4 hameau de Bouzole')
						->setOwner($jeanMichelOwner)
						->addRegion($idfRegion);
		$manager->persist($jmRoom1);
		$manager->flush();
		$jmRoom1->addImageAsset((new ImageAsset())
									->getSetFromURL('https://upload.wikimedia.org/wikipedia/commons/thumb/e/e3/Ferme_de_Sougey.jpg/1200px-Ferme_de_Sougey.jpg',
													Room::imgDirRelConfig, Room::imgDirAbsConfig, $jmRoom1,
													$this->container, $this->fileUploader))
				->addImageAsset((new ImageAsset())
									->getSetFromURL('https://www.lafermedesmarmottes.com/wp-content/uploads/2015/01/ferme-des-marmottes-poules.jpg',
													Room::imgDirRelConfig, Room::imgDirAbsConfig, $jmRoom1,
													$this->container, $this->fileUploader))
				->addImageAsset((new ImageAsset())
									->getSetFromURL('https://www.lafermedesmarmottes.com/wp-content/uploads/2015/01/la-ferme-des-marmottes-visites-vercors.jpg',
													Room::imgDirRelConfig, Room::imgDirAbsConfig, $jmRoom1,
													$this->container, $this->fileUploader));
		
		$jmRoom2 = (new Room())
						->setSummary('Belle chambre spacieuse à Évry')
						->setDescription('Vue sur poulailler ancien.')
						->setCapacity(4)
						->setArea(40.0)
						->setPrice(70.0)
						->setAddress('6 hameau de Bouzole')
						->setOwner($jeanMichelOwner)
						->addRegion($idfRegion);
		$manager->persist($jmRoom2);
		$manager->flush();
		$jmRoom2->addImageAsset((new ImageAsset())
									->getSetFromURL('https://ideat.thegoodhub.com/wp-content/thumbnails/uploads/sites/3/2018/10/'
														. 'id-p-20181029-molteni-05-tt-width-1120-height-718-crop-1-bgcolor-ffffff.jpg',
													Room::imgDirRelConfig, Room::imgDirAbsConfig, $jmRoom2,
													$this->container, $this->fileUploader))
				->addImageAsset((new ImageAsset())
									->getSetFromURL('https://ideat.thegoodhub.com/wp-content/thumbnails/uploads/sites/3/2018/10/id-p-'
														.'20181029-molteni-03-tt-width-740-height-474-crop-1-bgcolor-ffffff-except_gif-1.jpg',
													Room::imgDirRelConfig, Room::imgDirAbsConfig, $jmRoom2,
													$this->container, $this->fileUploader))
				->addImageAsset((new ImageAsset())
									->getSetFromURL('https://ideat.thegoodhub.com/wp-content/thumbnails/uploads/sites/3/2018/10/id-p-'
														.'20181029-molteni-01-tt-width-740-height-474-crop-1-bgcolor-ffffff-except_gif-1.jpg',
													Room::imgDirRelConfig, Room::imgDirAbsConfig, $jmRoom2,
													$this->container, $this->fileUploader));
		
		$jmRoom3 = (new Room())
						->setSummary('Maison familliale')
						->setDescription('A proximité de Disney Land Paris.')
						->setCapacity(6)
						->setArea(400.0)
						->setPrice(160.0)
						->setAddress('91 rue de Lescapadrier')
						->setOwner($jeanMichelOwner)
						->addRegion($idfRegion);
		$manager->persist($jmRoom3);
		$manager->flush();
		$jmRoom3->addImageAsset((new ImageAsset())
										->getSetFromURL('https://www.pagesjaunes.fr/media/cviv/07216150_N_0002_photo.jpg',
														Room::imgDirRelConfig, Room::imgDirAbsConfig, $jmRoom3,
														$this->container, $this->fileUploader))
				->addImageAsset((new ImageAsset())
										->getSetFromURL('https://www.3dpaysage.fr/media/galerie-68/small/0wh800.jpg',
														Room::imgDirRelConfig, Room::imgDirAbsConfig, $jmRoom3,
														$this->container, $this->fileUploader));
		
		$geoffroyZardiClientAccount = new UserAccount();
		$geoffroyZardiClient = (new Client())
									->setUserAccount($geoffroyZardiClientAccount
														->addRole('ROLE_CLIENT')
														->setEmail('geoffroy.zardi@telecom-sudparis.eu')
														->setFirstName('Geoffroy')
														->setLastName('Zardi')
														->setPassword($this->passwordEncoder
																			->encodePassword($geoffroyZardiClientAccount,
																							'gzpasswd')));
		$manager->persist($geoffroyZardiClient);
		
		$lucasLoredoClientAccount = new UserAccount();
		$lucasLoredoClient = (new Client())
								->setUserAccount($lucasLoredoClientAccount
														->addRole('ROLE_CLIENT')
														->setEmail('lucas.loredo@telecom-sudparis.eu')
														->setFirstName('Loredo')
														->setLastName('Lucas')
														->setPassword($this->passwordEncoder
																			->encodePassword($lucasLoredoClientAccount,
																							'llpasswd')));
		$manager->persist($lucasLoredoClient);
				
		$jeanPalucaClientAccount = new UserAccount();
		$jeanPalucaClient = (new Client())
								->setUserAccount($jeanPalucaClientAccount
														->addRole('ROLE_CLIENT')
														->setEmail('jean.paluca@telecom-sudparis.eu')
														->setFirstName('Jean')
														->setLastName('Paluca')
														->setPassword($this->passwordEncoder
																			->encodePassword($jeanPalucaClientAccount,
																							'jppasswd')));
		$manager->persist($jeanPalucaClient);
		
		
		$gzJmRoom1Comment1 = (new Comment())
									->setText('Un certain charme rustique.')
									->setGrade(3)
									->setDateTime((new \DateTime())
														->setDate(2019, 10, 23)
														->setTime(19, 46, 17))
									->setRoom($jmRoom1)
									->setUserAccount($geoffroyZardiClientAccount);
		$manager->persist($gzJmRoom1Comment1);
		
		$jpJmRoom1Comment1 = (new Comment())
									->setText('Très bon accueil, super séjour!')
									->setGrade(4)
									->setDateTime((new \DateTime())
														->setDate(2019, 8, 1)
														->setTime(10, 41, 43))
									->setRoom($jmRoom1)
									->setUserAccount($jeanPalucaClientAccount);
		$manager->persist($jpJmRoom1Comment1);
		
		
		$gzJmRoom1Reservation = (new Reservation())
										->setStartDate((new \DateTime())->setDate(2019, 11, 28))
										->setEndDate((new \DateTime())->setDate(2019, 12, 2))
										->setNumberOfGuests(10)
										->setClient($geoffroyZardiClient)
										->setRoom($jmRoom1);
		$manager->persist($gzJmRoom1Reservation);
		
		
		$alexisLeGlaunecClientAccount = new UserAccount();
		$alexisLeGlaunecClient = (new Client())
									->setUserAccount($alexisLeGlaunecClientAccount
														->addRole('ROLE_CLIENT')
														->setEmail('alexis.le_glaunec@telecom-sudparis.eu')
														->setFirstName('Alexis')
														->setLastName('Le Glaunec')
														->setPassword($this->passwordEncoder
																			->encodePassword($alexisLeGlaunecClientAccount,
																							'algpasswd')));
		$manager->persist($alexisLeGlaunecClient);
		
		$algJmRoom1Reservation = (new Reservation())
										->setStartDate((new \DateTime())->setDate(2019, 11, 17))
										->setEndDate((new \DateTime())->setDate(2019, 11, 23))
										->setNumberOfGuests(13)
										->setClient($alexisLeGlaunecClient)
										->setRoom($jmRoom1);
		$manager->persist($algJmRoom1Reservation);
		
		$algJmRoom2Reservation = (new Reservation())
										->setStartDate((new \DateTime())->setDate(2019, 11, 17))
										->setEndDate((new \DateTime())->setDate(2019, 11, 23))
										->setNumberOfGuests(2)
										->setClient($alexisLeGlaunecClient)
										->setRoom($jmRoom2);
		$manager->persist($algJmRoom2Reservation);
		
		
		$homePage = new HomePage();
		$manager->persist($homePage);
		$manager->flush();
		$homePage->addBgImageAsset((new ImageAsset())
										->getSetFromURL('https://unsplash.com/photos/7Xl0a6KCDyM/download',
												HomePage::imgDirRelConfig, HomePage::imgDirAbsConfig,
												$homePage, $this->container, $this->fileUploader))
				->addBgImageAsset((new ImageAsset())
										->getSetFromURL('https://unsplash.com/photos/v0KkmlchPRI/download',
												HomePage::imgDirRelConfig, HomePage::imgDirAbsConfig,
												$homePage, $this->container, $this->fileUploader))
				->addBgImageAsset((new ImageAsset())
										->getSetFromURL('https://unsplash.com/photos/a6EzvPjXfBY/download',
												HomePage::imgDirRelConfig, HomePage::imgDirAbsConfig,
												$homePage, $this->container, $this->fileUploader))
				->addBgImageAsset((new ImageAsset())
										->getSetFromURL('https://unsplash.com/photos/-1zFsXJIJhA/download',
												HomePage::imgDirRelConfig, HomePage::imgDirAbsConfig,
												$homePage, $this->container, $this->fileUploader));
		
		
		$manager->flush();
	}
}