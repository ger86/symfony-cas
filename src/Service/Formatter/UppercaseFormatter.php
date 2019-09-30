<?php

namespace App\Service\Formatter;

class UppercaseFormatter implements FormatterInterface {

    public function format(string $text): string {
        return mb_strtoupper($text);
    }
}