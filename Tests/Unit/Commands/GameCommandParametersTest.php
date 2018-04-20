<?php

namespace Unit\Commands;

use AE\Commands\GameCommandParameters;
use AE\Domain\Game\Game;
use AE\Domain\Game\GuessedChars;
use AE\Domain\Game\WordToGuess;
use AE\Factory;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * @covers \AE\Commands\GameCommandParameters
 */
class GameCommandParametersTest extends TestCase
{
    /**
     * @var Factory | PHPUnit_Framework_MockObject_MockObject
     */
    private $factory;

    /**
     * @var GameCommandParameters
     */
    private $commandParameters;

    protected function setUp()
    {
        $this->factory = $this->createMock(Factory::class);

        $this->commandParameters = new GameCommandParameters($this->factory);
    }

    public function testCanGetWordToGuessInit()
    {
        $wordToGuess = $this->createMock(WordToGuess::class);
        $this->factory->method('createWordToGuess')->willReturn($wordToGuess);
        $this->assertInstanceOf(WordToGuess::class, $this->commandParameters->wordToGuessInit());
    }

    public function testCanGetGuessedCharsInit()
    {
        $guessedChars = $this->createMock(GuessedChars::class);
        $this->factory->method('createEmptyGuessedChars')->willReturn($guessedChars);
        $this->assertInstanceOf(GuessedChars::class, $this->commandParameters->guessedCharsInit());
    }

    public function testCanGetCorrectGame()
    {
        $game = $this->createMock(Game::class);
        $this->factory->method('createGame')->willReturn($game);

        $this->assertInstanceOf(Game::class, $this->commandParameters->createGameAfterGuess($game, 'test'));
    }
}
