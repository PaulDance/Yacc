<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\RegionRepository")
 */
class Region {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;
	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $name;
	/**
	 * @var string The lowercase version of the region's name.
	 * Set automatically when assigning a new name. A getter is available.
	 * @ORM\Column(type="string", length=255)
	 */
	private $nameLowercase;
	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $presentation;
	/**
	 * @var string The lowercase version of the region's presentation.
	 * Set automatically when assigning a new presentation. A getter is available.
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $presentationLowercase;
	/**
	 * @ORM\Column(type="string", length=2, nullable=true)
	 */
	private $country;
	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Room", mappedBy="regions")
	 */
	private $rooms;
	
	public function __construct() {
		$this->rooms = new ArrayCollection();
	}
	
	/**
	 * Makes a textual representation of the Region object containing its
	 * id, name and country code.
	 *
	 * @return String: The String representing the object.
	 */
	public function __toString(): String {
		return "$this->id: $this->name @ $this->country";
	}
	
	public function getId(): ?int {
		return $this->id;
	}
	
	public function getName(): ?string {
		return $this->name;
	}
	
	/**
	 * @return string|NULL The lowercase version of the region's name.
	 */
	public function getNameLowercase(): ?string {
		return $this->nameLowercase;
	}
	
	/**
	 * Sets the region's name to the new given value.
	 * Also computes and stores the lowercase version separately.
	 *
	 * @param string $name The new value.
	 * @return self The underlying Region object.
	 */
	public function setName(string $name): self {
		$this->name = $name;
		$this->nameLowercase = mb_strtolower($this->name);
		return $this;
	}
	
	public function getPresentation(): ?string {
		return $this->presentation;
	}
	
	/**
	 * @return string|NULL The lowercase version of the region's presentation.
	 */
	public function getPresentationLowercase(): ?string {
		return $this->presentationLowercase;
	}
	
	/**
	 * Sets the region's presentation to the new given value.
	 * Also computes and stores the lowercase version separately.
	 *
	 * @param string $presentation The new value.
	 * @return self The underlying Region object.
	 */
	public function setPresentation(?string $presentation): self {
		$this->presentation = $presentation;
		$this->presentationLowercase = mb_strtolower($this->presentation);
		return $this;
	}
	
	public function getCountry(): ?string {
		return $this->country;
	}
	
	public function setCountry(?string $country): self {
		$this->country = $country;
		return $this;
	}
	
	/**
	 * @return Collection|Room[]
	 */
	public function getRooms(): Collection {
		return $this->rooms;
	}
	
	public function addRoom(Room $room): self {
		if (!$this->rooms->contains($room)) {
			$this->rooms[] = $room;
			$room->addRegion($this);
		}
		
		return $this;
	}
	
	public function removeRoom(Room $room): self {
		if ($this->rooms->contains($room)) {
			$this->rooms->removeElement($room);
			$room->removeRegion($this);
		}
		
		return $this;
	}
}
