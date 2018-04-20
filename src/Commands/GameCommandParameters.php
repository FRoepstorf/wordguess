<?php

declare(strict_types=1);

namespace AE\Commands;

use AE\Domain\Game\Game;
use AE\Domain\Game\GuessedChars;
use AE\Domain\Game\WordToGuess;
use AE\Factory;

class GameCommandParameters
{
    /**
     * @var Factory
     */
    private $factory;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public function wordToGuessInit(): WordToGuess
    {
        return $this->factory->createWordToGuess();
    }

    public function guessedCharsInit(): GuessedChars
    {
        return $this->factory->createEmptyGuessedChars();
    }

    public function createGameAfterGuess(Game $game, string $newGuess)
    {
        return $this->gameAfterGuess($game, $newGuess);
    }

    /**
     *  Replaces unguessed chars with underscores and returns a new Game value object
     */
    private function gameAfterGuess(Game $game, string $newGuess): Game
    {
        $guessedChars = $game->guessedChars()->asString() . " " . $newGuess;
        $allLeters = range('a', 'z');
        $lettersGuessed = explode(' ', $guessedChars);
        $unguessed = array_diff($allLeters, $lettersGuessed);
        $remainingWordToGuess = str_replace($unguessed, ' _', $game->wordToGuess()->asString());

        return $this->factory->createGame(
            $game->id(),
            $guessedChars,
            $game->wordToGuess()->asString(),
            $remainingWordToGuess
        );
    }
}
