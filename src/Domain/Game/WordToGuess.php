<?php

declare(strict_types=1);

namespace AE\Domain\Game;

class WordToGuess
{
    /**
     * @var string
     */
    private $word;

    public function __construct(string $word)
    {
        $this->word = $word;
    }

    public function asString(): string
    {
        return $this->word;
    }
}
