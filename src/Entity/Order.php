<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $customerName;

    #[ORM\Column(type: 'string', length: 255)]
    private $customerEmail;

    #[ORM\Column(type: 'text')]
    private $customerAddress;

    #[ORM\Column(type: 'float')]
    private $total;

    public function __construct(
        string $customerName,
        string $customerEmail,
        string $customerAddress,
        float $total
    ) {
        $this->customerName = $customerName;
        $this->customerEmail = $customerEmail;
        $this->customerAddress = $customerAddress;
        $this->total = $total;
    }

    // Getter pour l'ID
    public function getId(): ?int
    {
        return $this->id;
    }

    // Getter et setter pour customerName
    public function getCustomerName(): ?string
    {
        return $this->customerName;
    }

    public function setCustomerName(string $customerName): self
    {
        $this->customerName = $customerName;
        return $this;
    }

    // Getter et setter pour customerEmail
    public function getCustomerEmail(): ?string
    {
        return $this->customerEmail;
    }

    public function setCustomerEmail(string $customerEmail): self
    {
        $this->customerEmail = $customerEmail;
        return $this;
    }

    // Getter et setter pour customerAddress
    public function getCustomerAddress(): ?string
    {
        return $this->customerAddress;
    }

    public function setCustomerAddress(string $customerAddress): self
    {
        $this->customerAddress = $customerAddress;
        return $this;
    }

    // Getter et setter pour total
    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;
        return $this;
    }
}
