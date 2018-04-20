<?php

namespace Unit\Domain\Game;


use AE\Domain\Game\Game;
use AE\Domain\Game\GuessedChars;
use AE\Domain\Game\RemainingWordToGuess;
use AE\Domain\Game\WordToGuess;
use PHPUnit\Framework\TestCase;

/**
 * @covers AE\Domain\Game\Game
 */
class GameTest extends TestCase
{
    /**
     * @var Game
     */
    private $game;

    protected function setUp() {
        $id = 1;
        $guessedChars = $this->createMock(GuessedChars::class);
        $guessedChars->method('asString')->willReturn("test");
        $wordToGuess = $this->createMock(WordToGuess::class);
        $wordToGuess->method('asString')->willReturn("testWord");
        $remainingWordToGuess = $this->createMock(RemainingWordToGuess::class);
        $remainingWordToGuess->method('asString')->willReturn('remainingWord');
        $this->game = new Game(
            $id,
            $guessedChars,
            $wordToGuess,
            $remainingWordToGuess
        );
    }

    public function testCanGetId()
    {
        $this->assertSame(1, $this->game->id());
    }

    public function testCanGetGuessedChars()
    {
        $this->assertInstanceOf(GuessedChars::class, $this->game->guessedChars());
    }

    public function testCanGetWordToGuess()
    {
        $this->assertInstanceOf(WordToGuess::class, $this->game->wordToGuess());
    }

    public function testCanGetRemainingWordToGuess()
    {
        $this->assertInstanceOf(RemainingWordToGuess::class, $this->game->remainingWordToGuess());
    }
}
