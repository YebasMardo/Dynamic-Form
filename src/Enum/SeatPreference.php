<?php

namespace App\Enum;

use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Contracts\Translation\TranslatableInterface;

enum SeatPreference: string implements TranslatableInterface
{
    case WINDOW = 'WINDOW';
    case AISLE = 'AISLE';
    case MIDDLE = 'MIDDLE';
    case EXIT_ROW = 'EXIT_ROW';
    case TABLE = 'TABLE';
    case QUIET_ZONE = 'QUIET_ZONE';

    public static function plane(): array
    {
        return [
            self::WINDOW,
            self::AISLE,
            self::MIDDLE,
            self::EXIT_ROW,
        ];
    }

    public static function train(): array
    {
        return [
            self::WINDOW,
            self::AISLE,
            self::TABLE,
            self::QUIET_ZONE,
        ];
    }

    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        return match ($this) {
            self::WINDOW => 'Fenêtre',
            self::AISLE => 'Couloir',
            self::MIDDLE => 'Milieu',
            self::EXIT_ROW => 'Rang de sortie',
            self::TABLE => 'Table',
            self::QUIET_ZONE => 'Zone calme',
        };
    }
}