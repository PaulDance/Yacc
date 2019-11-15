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
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $firstName;
	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $lastName;
	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="client", orphanRemoval=true)
	 */
	private $comments;
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
	
	public function getFirstName(): ?string {
		return $this->firstName;
	}
	
	public function setFirstName(?string $firstName): self {
		$this->firstName = $firstName;
		return $this;
	}
	
	public function getLastName(): ?string {
		return $this->lastName;
	}
	
	public function setLastName(string $lastName): self {
		$this->lastName = $lastName;
		return $this;
	}
	
	/**
	 * @return Collection|Comment[]
	 */
	public function getComments(): Collection {
		return $this->comments;
	}
	
	public function addComment(Comment $comment): self {
		if (!$this->comments->contains($comment)) {
			$this->comments[] = $comment;
			$comment->setClient($this);
		}
		
		return $this;
	}
	
	public function removeComment(Comment $comment): self {
		if ($this->comments->contains($comment)) {
			$this->comments->removeElement($comment);
			// set the owning side to null (unless already changed)
			if ($comment->getClient() === $this) {
				$comment->setClient(null);
			}
		}
		
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
			// set the owning side to null (unless already changed)
			if ($reservation->getClient() === $this) {
				$reservation->setClient(null);
			}
		}
		
		return $this;
	}
}
