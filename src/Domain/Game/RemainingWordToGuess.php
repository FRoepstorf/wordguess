<?php

declare(strict_types=1);

namespace AE\Domain\Game;

class RemainingWordToGuess
{
    /**
     * @var string
     */
    private $remainingWord;

    public function __construct(string $remainingWord)
    {
        $this->remainingWord = $remainingWord;
    }

    public function asString(): string
    {
        return $this->remainingWord;
    }
}
