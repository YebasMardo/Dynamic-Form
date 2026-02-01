<?php

namespace App\Model;

use App\Enum\FlightClass;
use App\Enum\SeatPreference;
use App\Enum\TransportType;
use DateTimeImmutable;

class Reservation
{
    public function __construct(
        public ?TransportType $transportType = null,
        public ?FlightClass $flightClass = null,
        public ?SeatPreference $seatPreference = null,
        public ?bool $isRoundTrip = null,
        public ?DateTimeImmutable $departureDate = null,
        public ?DateTimeImmutable $returnDate = null,
    )
    {

    }
}