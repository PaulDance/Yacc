<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;
	/**
	 * @ORM\Column(type="text")
	 */
	private $text;
	/**
	 * @ORM\Column(type="smallint", nullable=true)
	 */
	private $grade;
	/**
	 * @ORM\Column(type="datetime")
	 */
	private $dateTime;
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\UserAccount", inversedBy="comments")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $userAccount;
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Room", inversedBy="comments")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $room;
	
	public function getId(): ?int {
		return $this->id;
	}
	
	public function getText(): ?string {
		return $this->text;
	}
	
	public function setText(string $text): self {
		$this->text = $text;
		return $this;
	}
	
	public function getGrade(): ?int {
		return $this->grade;
	}
	
	public function setGrade(int $grade): self {
		$this->grade = $grade;
		return $this;
	}
	
	public function getDateTime(): ?\DateTimeInterface {
		return $this->dateTime;
	}
	
	public function setDateTime(\DateTimeInterface $dateTime): self {
		$this->dateTime = $dateTime;
		return $this;
	}
	
	public function getUserAccount(): ?UserAccount {
		return $this->userAccount;
	}
	
	public function setUserAccount(?UserAccount $userAccount): self {
		$this->userAccount = $userAccount;
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
