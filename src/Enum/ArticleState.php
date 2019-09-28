<?php

namespace App\Enum;

class ArticleState
{
    const DRAFT = 1;
    const PENDING_OF_APPROVAL = 2;
    const PUBLISHED = 3;

    private static $states = [
        'Borrador' => self::DRAFT,
        'Pendiente de aprobación' => self::PENDING_OF_APPROVAL,
        'Publicado' => self::PUBLISHED
    ];

    public static function getStates(): array
    {
        return self::$states;
    }

    public static function fromString($index): int
    {
        return self::$states[$index];
    }

    public static function toString($value): string
    {
        return array_search($value, self::$states);
    }
}
