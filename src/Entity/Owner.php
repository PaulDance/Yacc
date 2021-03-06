<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\OwnerRepository")
 */
class Owner {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;
	/**
	 * @ORM\OneToOne(targetEntity="App\Entity\UserAccount", inversedBy="possibleOwner", cascade={"persist", "remove"})
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $userAccount;
	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $address;
	/**
	 * @ORM\Column(type="string", length=2, nullable=true)
	 */
	private $country;
	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Room", mappedBy="owner")
	 */
	private $rooms;
	
	public function __construct() {
		$this->rooms = new ArrayCollection();
	}
	
	/**
	 * Makes a textual representation of the Owner object containing its
	 * id, firstname, lastname, address and country code.
	 *
	 * @return String: The String representing the object.
	 */
	public function __toString(): String {
		return "$this->id: $this->userAccount @ $this->address $this->country";
	}
	
	public function getId(): ?int {
		return $this->id;
	}
	
	public function getUserAccount(): ?UserAccount {
		return $this->userAccount;
	}
	
	public function setUserAccount(UserAccount $userAccount): self {
		$this->userAccount = $userAccount;
		return $this;
	}
	
	public function getAddress(): ?string {
		return $this->address;
	}
	
	public function setAddress(?string $address): self {
		$this->address = $address;
		return $this;
	}
	
	public function getCountry(): ?string {
		return $this->country;
	}
	
	public function setCountry(string $country): self {
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
			$room->setOwner($this);
		}
		
		return $this;
	}
	
	public function removeRoom(Room $room): self {
		if ($this->rooms->contains($room)) {
			$this->rooms->removeElement($room);
			
			if ($room->getOwner() === $this) {
				$room->setOwner(null);
			}
		}
		
		return $this;
	}
}
