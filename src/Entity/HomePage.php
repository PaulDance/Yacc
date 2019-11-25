<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\HomePageRepository")
 */
class HomePage {
	/**
	 * The configuration variable pointing to the home images directory,
	 * relatively to the public assets base path.
	 */
	public const imgDirRelConfig = 'home_img_dir_rel';
	/**
	 * The configuration variable pointing to the home images directory,
	 * relatively to the project's root path ("absolute path").
	 */
	public const imgDirAbsConfig = 'home_img_dir_abs';
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;
	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\ImageAsset", mappedBy="possibleHomePage", cascade={"persist"})
	 */
	private $bgImageAssets;
	
	public function __construct() {
		$this->bgImageAssets = new ArrayCollection();
	}
	
	public function getId(): ?int {
		return $this->id;
	}
	
	/**
	 * @return Collection|ImageAsset[]
	 */
	public function getBgImageAssets(): Collection {
		return $this->bgImageAssets;
	}
	
	public function getRandBgImgAsset(): ImageAsset {
		return $this->bgImageAssets[random_int(0, $this->bgImageAssets->count() - 1)];
	}
	
	public function addBgImageAsset(ImageAsset $bgImageAsset): self {
		if (!$this->bgImageAssets->contains($bgImageAsset)) {
			$this->bgImageAssets[] = $bgImageAsset;
			$bgImageAsset->setHomePage($this);
		}
		
		return $this;
	}
	
	public function removeBgImageAsset(ImageAsset $bgImageAsset): self {
		if ($this->bgImageAssets->contains($bgImageAsset)) {
			$this->bgImageAssets->removeElement($bgImageAsset);
			
			if ($bgImageAsset->getPossibleHomePage() === $this) {
				$bgImageAsset->setHomePage(null);
			}
		}
		
		return $this;
	}
}
