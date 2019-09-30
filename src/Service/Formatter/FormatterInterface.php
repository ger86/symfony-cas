<?php

namespace App\Service\Formatter;

interface FormatterInterface {
    public function format(string $text): string;
}