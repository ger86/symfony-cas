<?php

namespace App\Service\Formatter;

class FormatterManager {
    private $formatters;

    public function __construct(iterable $formatters)
    {
        $this->formatters = iterator_to_array($formatters);
    }

    public function formatText(string $text): string {
        foreach ($this->formatters as $formatter) {
            $text = $formatter->format($text);
        }
        return $text;
    }
}