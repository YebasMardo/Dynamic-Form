<?php

namespace App\Enum;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum FlightClass: string implements TranslatableInterface
{
    case ECONOMY = 'ECONOMY';
    case PREMIUM_ECONOMY = 'PREMIUM_ECONOMY';
    case BUSINESS = 'BUSINESS';
    case FIRST_CLASS = 'FIRST_CLASS';

    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        return match ($this) {
            self::ECONOMY => 'Économique',
            self::PREMIUM_ECONOMY => 'Économique premium',
            self::BUSINESS => 'Affaires',
            self::FIRST_CLASS => 'Première classe',
        };
    }
}