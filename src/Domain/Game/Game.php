<?php

declare(strict_types=1);

namespace AE\Domain\Game;

class Game
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var GuessedChars
     */
    private $guessedChars;

    /**
     * @var WordToGuess
     */
    private $wordToGuess;

    /**
     * @var RemainingWordToGuess
     */
    private $remainingWordtoGuess;

    public function __construct(
        int $id,
        GuessedChars $guessedChars,
        WordToGuess $wordToGuess,
        RemainingWordToGuess $remainingWordToGuess = null
    ) {
        $this->id = $id;
        $this->guessedChars = $guessedChars;
        $this->wordToGuess = $wordToGuess;
        $this->remainingWordtoGuess = $remainingWordToGuess;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function guessedChars(): GuessedChars
    {
        return $this->guessedChars;
    }

    public function wordToGuess(): WordToGuess
    {
        return $this->wordToGuess;
    }

    public function remainingWordToGuess(): RemainingWordToGuess
    {
        return $this->remainingWordtoGuess;
    }
}
