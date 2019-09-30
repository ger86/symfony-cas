<?php

namespace App\Twig;

use App\Service\Formatter\FormatterManager;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class BlogExtension extends AbstractExtension {
    private $formatterManager;

    public function __construct(FormatterManager $formatterManager)
    {
        $this->formatterManager = $formatterManager;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('getCharactersCount', [$this, 'getCharactersCount'])
        ];
    }

    public function getFilters()
    {
        return [
            new TwigFilter('withHeaderImage', [$this, 'withImage'], ['is_safe' => ['html']]),
            new TwigFilter('withFormattedText', [$this, 'withFormattedText'], ['is_safe' => ['html']])
        ];
    }

    public function withFormattedText(string $text): string {
        return $this->formatterManager->formatText($text);
    }

    public function getCharactersCount(string $text): int {
        return strlen(strip_tags($text));
    }

    public function withImage(string $text): string {
        return sprintf('<img src="%s"><br>%s', 'http://placekitten.com/g/200/300', $text);
    }
}