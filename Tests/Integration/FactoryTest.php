<?php

namespace Integration;

use AE\Commands\CreateGameCommand;
use AE\Commands\GuessCommand;
use AE\Configuration;
use AE\Domain\Game\Game;
use AE\Domain\Game\GuessedChars;
use AE\Domain\Game\WordToGuess;
use AE\Domain\Shared\PdoConfiguration;
use AE\Factory;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * @covers \AE\Factory
 */
class FactoryTest extends TestCase
{
    /**
     * @var Factory
     */
    private $factory;

    /**
     * @var Configuration | PHPUnit_Framework_MockObject_MockObject
     */
    private $configuration;

    protected function setUp()
    {
        $this->configuration = $this->createMock(Configuration::class);
        $pdoConfig = $this->createMock(PdoConfiguration::class);
        $pdoConfig->method('username')->willReturn('root');
        $pdoConfig->method('password')->willReturn('');
        $pdoConfig->method('host')->willReturn('localhost:3308');
        $pdoConfig->method('database')->willReturn('hangman');
        $this->configuration->method('pdo')->willReturn($pdoConfig);
        $this->factory = new Factory($this->configuration);
    }

    public function testCanGetRandomWord()
    {
        $this->configuration->method('wordConfig')->willReturn(['test']);
        $this->assertInstanceOf(WordToGuess::class, $this->factory->createWordToGuess());
    }

    public function testCanCreateEmptyGuessedChars()
    {
        $this->assertInstanceOf(GuessedChars::class, $this->factory->createEmptyGuessedChars());
    }

    public function testCanCreateGame()
    {
        $this->assertInstanceOf(Game::class, $this->factory->createGame(1,'g','gh','g_'));
    }

    public function testCanCreateGameCommand()
    {
        $this->assertInstanceOf(CreateGameCommand::class, $this->factory->createGameCommand());
    }

    public function testCanCreateGuessCommand()
    {
        $this->assertInstanceOf(GuessCommand::class, $this->factory->createGuessCommand());
    }
}
