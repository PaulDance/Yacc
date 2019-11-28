<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserAccountRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class UserAccount implements UserInterface {
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
	 * @ORM\Column(type="string", length=180, unique=true)
	 */
	private $email;
	/**
	 * @ORM\Column(type="json")
	 */
	private $roles = [];
	/**
	 * @var string The hashed password
	 * @ORM\Column(type="string")
	 */
	private $password;
	/**
	 * @ORM\OneToOne(targetEntity="App\Entity\Client", mappedBy="userAccount", cascade={"persist", "remove"})
	 */
	private $possibleClient;
	/**
	 * @ORM\OneToOne(targetEntity="App\Entity\Owner", mappedBy="userAccount", cascade={"persist", "remove"})
	 */
	private $possibleOwner;
	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="userAccount", orphanRemoval=true)
	 */
	private $comments;
	
	public function __construct() {
		$this->comments = new ArrayCollection();
	}
	
	public function __toString(): string {
		return $this->getUsername();
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
	
	public function getEmail(): ?string {
		return $this->email;
	}
	
	public function setEmail(string $email): self {
		$this->email = $email;
		return $this;
	}
	
	/**
	 * A visual identifier that represents this user.
	 *
	 * @see UserInterface
	 */
	public function getUsername(): string {
		return "$this->firstName $this->lastName <$this->email>";
	}
	
	/**
	 * @see UserInterface
	 */
	public function getRoles(): array {
		$roles = $this->roles;
		$roles[] = 'ROLE_USER';
		return array_unique($roles);
	}
	
	public function setRoles(array $roles): self {
		$this->roles = $roles;
		return $this;
	}
	
	/**
	 * Adds a new role to the user account.
	 * If the given role
	 * is already present in the account roles, then nothing
	 * is done.
	 *
	 * @param string $role The new role to add.
	 * @return self The underlying UserAccount.
	 */
	public function addRole(string $role): self {
		if (!in_array($role, $this->roles)) {
			$this->roles[] = $role;
		}
		
		return $this;
	}
	
	/**
	 * Determines whether the UserAccount is granted the given
	 * $role or not.
	 *
	 * @param string $role The role to test.
	 * @return bool The result of the test.
	 */
	public function hasRole(string $role): bool {
		return in_array($role, $this->getRoles());
	}
	
	/**
	 * @see UserInterface
	 */
	public function getPassword(): string {
		return (string) $this->password;
	}
	
	public function setPassword(string $password): self {
		$this->password = $password;
		return $this;
	}
	
	/**
	 * @see UserInterface
	 */
	public function getSalt() {
		// Not needed when using the "bcrypt" algorithm in security.yaml.
	}
	
	/**
	 * @see UserInterface
	 */
	public function eraseCredentials() {
		// If you store any temporary, sensitive data on the user, clear it here.
	}
	
	public function getPossibleClient(): ?Client {
		return $this->possibleClient;
	}
	
	public function setPossibleClient(Client $possibleClient): self {
		$this->possibleClient = $possibleClient;
		
		if ($possibleClient->getUserAccount() !== $this) {
			$possibleClient->setUserAccount($this);
		}
		
		return $this;
	}
	
	public function getPossibleOwner(): ?Owner {
		return $this->possibleOwner;
	}
	
	public function setPossibleOwner(Owner $possibleOwner): self {
		$this->possibleOwner = $possibleOwner;
		
		if ($possibleOwner->getUserAccount() !== $this) {
			$possibleOwner->setUserAccount($this);
		}
		
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
			$comment->setUserAccount($this);
		}
		
		return $this;
	}
	
	public function removeComment(Comment $comment): self {
		if ($this->comments->contains($comment)) {
			$this->comments->removeElement($comment);
			
			if ($comment->getUserAccount() === $this) {
				$comment->setUserAccount(null);
			}
		}
		
		return $this;
	}
}
