<?php

namespace App\Service;

class QuoteGenerator {

    public function getQuote(): string {
        $quotes = ['a', 'b', 'c'];

        return $quotes[array_rand($quotes)];
    }
}