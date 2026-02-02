<?php

namespace App\Entity;

use App\Enum\FlightClass;
use App\Enum\SeatPreference;
use App\Enum\TransportType;
use App\Repository\ReservationRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
#[ORM\Table(name: 'reservation')]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', enumType: TransportType::class)]
    #[Assert\NotNull]
    private ?TransportType $transportType = null;

    #[ORM\Column(type: 'string', enumType: FlightClass::class, nullable: true)]
    private ?FlightClass $flightClass = null;

    #[ORM\Column(type: 'string', enumType: SeatPreference::class, nullable: true)]
    private ?SeatPreference $seatPreference = null;

    #[ORM\Column(type: Types::BOOLEAN, nullable: true)]
    private ?bool $isRoundTrip = null;

    #[ORM\Column(type: 'date_immutable')]
    #[Assert\NotNull]
    private ?DateTimeImmutable $departureDate = null;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?DateTimeImmutable $returnDate = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTransportType(): ?TransportType
    {
        return $this->transportType;
    }

    public function setTransportType(?TransportType $transportType): self
    {
        $this->transportType = $transportType;
        return $this;
    }

    public function getFlightClass(): ?FlightClass
    {
        return $this->flightClass;
    }

    public function setFlightClass(?FlightClass $flightClass): self
    {
        $this->flightClass = $flightClass;
        return $this;
    }

    public function getSeatPreference(): ?SeatPreference
    {
        return $this->seatPreference;
    }

    public function setSeatPreference(?SeatPreference $seatPreference): self
    {
        $this->seatPreference = $seatPreference;
        return $this;
    }

    public function isRoundTrip(): ?bool
    {
        return $this->isRoundTrip;
    }

    public function setIsRoundTrip(?bool $isRoundTrip): self
    {
        $this->isRoundTrip = $isRoundTrip;
        return $this;
    }

    public function getDepartureDate(): ?DateTimeImmutable
    {
        return $this->departureDate;
    }

    public function setDepartureDate(?DateTimeImmutable $departureDate): self
    {
        $this->departureDate = $departureDate;
        return $this;
    }

    public function getReturnDate(): ?DateTimeImmutable
    {
        return $this->returnDate;
    }

    public function setReturnDate(?DateTimeImmutable $returnDate): self
    {
        $this->returnDate = $returnDate;
        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
