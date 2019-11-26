<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Service\FileUploader;


/**
 * Represents an object which mainly stores a single attribute:
 * an asset path to an image.
 *
 * @author Paul Mabileau <paulmabileau@hotmail.fr>
 * @ORM\Entity(repositoryClass="App\Repository\ImageAssetRepository")
 */
class ImageAsset {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;
	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $assetPath;
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Room", inversedBy="imageAssets")
	 */
	private $possibleRoom;
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Region", inversedBy="imageAssets")
	 */
	private $possibleRegion;
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\HomePage", inversedBy="bgImageAssets")
	 */
	private $possibleHomePage;
	
	public function __toString(): string {
		return "$this->id @ $this->assetPath";
	}
	
	public function getId(): ?int {
		return $this->id;
	}
	
	/**
	 * Gets the file path relative to the assets location.
	 *
	 * @return string|NULL The asset path.
	 */
	public function getAssetPath(): ?string {
		return $this->assetPath;
	}
	
	/**
	 * Sets the asset path to the new given value, which should
	 * lead from the assets location to a file actually present.
	 *
	 * @param string $assetPath The new asset path.
	 * @return self
	 */
	public function setAssetPath(string $assetPath): self {
		$this->assetPath = $assetPath;
		return $this;
	}
	
	/**
	 * Sets the asset path automatically from a configuration parameter
	 * and from an entity.
	 * It will resolve the underlying directory path
	 * and add the entity's id behind it to help manage the file system
	 * easily.
	 *
	 * @param string $configRelDir A configuration parameter that points
	 *        to a directory. It has to be known by the $container.
	 * @param string $fileName The associated file's base name.
	 * @param object $entity An entity that is linked to the ImageAsset.
	 * @param ContainerInterface $container A parameter container.
	 * @return self
	 */
	public function setAssetPathFromConfig(string $configRelDir,
											string $fileName,
											object $entity,
											ContainerInterface $container): self {
		return $this->setAssetPath($container->getParameter($configRelDir)
									. '/' . strval($entity->getId())
									. '/' . $fileName);
	}
	
	/**
	 * Fetches an image from the Web, stores it at the right place and sets
	 * the asset path accordingly also automatically from configuration
	 * parameters and an entity.
	 *
	 * @param string $URL An URL which should point to an available image.
	 * @param string $configRelDir A configured directory parameter, relative
	 *        to the asset directory path.
	 * @param string $configAbsDir The configured parameter which should be
	 *        the 'absolute' version, that is starting from the project's
	 *        root.
	 * @param object $entity An entity that is linked to the ImageAsset.
	 * @param ContainerInterface $container A parameter container.
	 * @param FileUploader $fileUploader A FileUploader service instance.
	 * @return self
	 */
	public function getSetFromURL(string $URL, string $configRelDir,
									string $configAbsDir, object $entity,
									ContainerInterface $container,
									FileUploader $fileUploader): self {
		$fileUploader->setTargetDirectoryFromConfig($configAbsDir,
													'/' . strval($entity->getId()));
		
		return $this->setAssetPathFromConfig($configRelDir,
											$fileUploader->uploadFromURL($URL),
											$entity,
											$container);
	}
	
	/**
	 * Gets the Room object that is possibly linked to the ImageAsset.
	 *
	 * @return Room|NULL The object, which can be valued to NULL.
	 */
	public function getPossibleRoom(): ?Room {
		return $this->possibleRoom;
	}
	
	/**
	 * Sets the room that this ImageAsset should be linked to.
	 *
	 * @param Room $room The Room object in question.
	 * @return self
	 */
	public function setRoom(?Room $room): self {
		$this->possibleRoom = $room;
		return $this;
	}
	
	/**
	 * Gets the Region object that is possibly linked to the ImageAsset.
	 *
	 * @return Room|NULL The object, which can be valued to NULL.
	 */
	public function getPossibleRegion(): ?Region {
		return $this->possibleRegion;
	}
	
	/**
	 * Sets the region that this ImageAsset should be linked to.
	 *
	 * @param Region $room The Room object in question.
	 * @return self
	 */
	public function setRegion(?Region $region): self {
		$this->possibleRegion = $region;
		return $this;
	}
	
	/**
	 * Gets the HomePage object that is possibly linked to the ImageAsset.
	 *
	 * @return HomePage|NULL The object, which can be valued to NULL.
	 */
	public function getPossibleHomePage(): ?HomePage {
		return $this->possibleHomePage;
	}
	
	/**
	 * Sets the home page that this ImageAsset should be linked to.
	 *
	 * @param HomePage $homePage The HomePage object in question.
	 * @return self
	 */
	public function setHomePage(?HomePage $homePage): self {
		$this->possibleHomePage = $homePage;
		return $this;
	}
}
