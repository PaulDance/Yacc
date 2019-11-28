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
	 * @ORM\Column(type="date")
	 */
	private $startDate;
	/**
	 * @ORM\Column(type="date")
	 */
	private $endDate;
	/**
	 * @ORM\Column(type="smallint")
	 */
	private $numberOfGuests;
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="reservations")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $client;
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Room", inversedBy="reservations")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $room;
	
	public function __construct() {
		$this->rooms = new ArrayCollection();
	}
	
	public function getId(): ?int {
		return $this->id;
	}
	
	public function getStartDate(): ?\DateTimeInterface {
		return $this->startDate;
	}
	
	public function setStartDate(\DateTimeInterface $startDate): self {
		$this->startDate = $startDate;
		return $this;
	}
	
	public function getEndDate(): ?\DateTimeInterface {
		return $this->endDate;
	}
	
	public function setEndDate(\DateTimeInterface $endDate): self {
		$this->endDate = $endDate;
		return $this;
	}
	
	/**
	 * Indicates true if the given dates intersect with the reservation.
	 * 
	 * @param \DateTimeInterface $startDate The check-in date.
	 * @param \DateTimeInterface $endDate The check-out date.
	 * @return bool The result of the test.
	 */
	public function intersectsWith(\DateTimeInterface $startDate, \DateTimeInterface $endDate): bool {
		return $this->startDate < $endDate && $startDate < $this->endDate;
	}
	
	/**
	 * Checks if the reservation intersects with the given other one.
	 * 
	 * @param Reservation $anotherOne Another Reservation to check.
	 * @return bool The result of the test.
	 */
	public function intersectsWithReservation(Reservation $anotherOne): bool {
		return $this->intersectsWith($anotherOne->startDate, $anotherOne->endDate);
	}
	
	public function getNumberOfGuests(): ?int {
		return $this->numberOfGuests;
	}
	
	public function setNumberOfGuests(int $numberOfGuests): self {
		$this->numberOfGuests = $numberOfGuests;
		return $this;
	}
	
	public function getClient(): ?Client {
		return $this->client;
	}
	
	public function setClient(?Client $client): self {
		$this->client = $client;
		return $this;
	}
	
	public function getRoom(): ?Room {
		return $this->room;
	}
	
	public function setRoom(?Room $room): self {
		$this->room = $room;
		return $this;
	}
}
