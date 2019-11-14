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
	 * @ORM\Column(type="smallint")
	 */
	private $grade;
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="comments")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $client;
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
