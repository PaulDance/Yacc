<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;
	/**
	 * @ORM\Column(type="dateinterval")
	 */
	private $dateInterval;
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="reservations")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $client;
	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Room", inversedBy="reservations")
	 */
	private $rooms;
	
	public function __construct() {
		$this->rooms = new ArrayCollection();
	}
	
	public function getId(): ?int {
		return $this->id;
	}
	
	public function getDateInterval(): ?\DateInterval {
		return $this->dateInterval;
	}
	
	public function setDateInterval(\DateInterval $dateInterval): self {
		$this->dateInterval = $dateInterval;
		return $this;
	}
	
	public function getClient(): ?Client {
		return $this->client;
	}
	
	public function setClient(?Client $client): self {
		$this->client = $client;
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
		}
		
		return $this;
	}
	
	public function removeRoom(Room $room): self {
		if ($this->rooms->contains($room)) {
			$this->rooms->removeElement($room);
		}
		
		return $this;
	}
}
