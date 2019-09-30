<?php

namespace App\Service\Formatter;

class ItalicFormatter implements FormatterInterface {
    public function format(string $text): string {
        return '<i>'.$text.'</i>';
    }
}