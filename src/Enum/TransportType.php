<?php
namespace App\Enum;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum TransportType: string implements TranslatableInterface
{
    case TRAIN = 'TRAIN';
    case PLANE = 'PLANE';

    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        return match ($this) {
            self::TRAIN => 'Train',
            self::PLANE => 'Avion',
        };
    }
}