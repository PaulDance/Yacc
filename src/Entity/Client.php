<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;
	/**
	 * @ORM\OneToOne(targetEntity="App\Entity\UserAccount", inversedBy="possibleClient", cascade={"persist", "remove"})
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $userAccount;
	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="client", orphanRemoval=true)
	 */
	private $reservations;
	
	public function __construct() {
		$this->comments = new ArrayCollection();
		$this->reservations = new ArrayCollection();
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
	
	/**
	 * @return Collection|Reservation[]
	 */
	public function getReservations(): Collection {
		return $this->reservations;
	}
	
	public function addReservation(Reservation $reservation): self {
		if (!$this->reservations->contains($reservation)) {
			$this->reservations[] = $reservation;
			$reservation->setClient($this);
		}
		
		return $this;
	}
	
	public function removeReservation(Reservation $reservation): self {
		if ($this->reservations->contains($reservation)) {
			$this->reservations->removeElement($reservation);
			
			if ($reservation->getClient() === $this) {
				$reservation->setClient(null);
			}
		}
		
		return $this;
	}
}
