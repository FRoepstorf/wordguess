<?php

declare(strict_types=1);

namespace AE\Domain\Game;

class GuessedChars
{
    /**
     * @var string
     */
    private $guessedChars;

    public function __construct(string $guessedChars)
    {
        $this->guessedChars = $guessedChars;
    }

    public function asString(): string
    {
        return $this->guessedChars;
    }
}
