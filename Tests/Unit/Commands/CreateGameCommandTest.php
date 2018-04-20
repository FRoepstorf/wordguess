<?php

namespace Unit\Commands;

use AE\Commands\CreateGameCommand;
use AE\Commands\GameCommandParameters;
use AE\Domain\Game\GuessedChars;
use AE\Domain\Game\Repository\GameMapper;
use AE\Domain\Game\WordToGuess;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @covers Ae\Commands\CreateGameCommand
 */
class CreateGameCommandTest extends TestCase
{
    /**
     * @var GameMapper | \PHPUnit_Framework_MockObject_MockObject
     */
    private $gameMapper;

    /**
     * @var GameCommandParameters | \PHPUnit_Framework_MockObject_MockObject
     */
    private $commandParameters;

    /**
     * @var CreateGameCommand
     */
    private $createGameCommand;

    /**
     * @var CommandTester
     */
    private $commandTester;

    protected function setUp()
    {
        $this->gameMapper = $this->createMock(GameMapper::class);
        $this->commandParameters = $this->createMock(GameCommandParameters::class);
        $wordToGuess = $this->createMock(WordToGuess::class);
        $guessedChars = $this->createMock(GuessedChars::class);
        $this->commandParameters->method('wordToGuessInit')->willReturn($wordToGuess);
        $this->commandParameters->method('guessedCharsInit')->willReturn($guessedChars);
        $this->createGameCommand = new CreateGameCommand($this->gameMapper, $this->commandParameters);
        $application = new Application();
        $application->add($this->createGameCommand);
        $command = $application->find('game:new');
        $this->commandTester = new CommandTester($command);
    }

    public function testCanExecute()
    {
        $this->gameMapper->expects($this->once())
                         ->method('persistNewGame');
        $this->gameMapper->expects($this->once())
                         ->method('deleteGame');

        $this->commandTester->execute(['game:new']);

        $this->assertSame($this->outputMessage(), $this->commandTester->getDisplay());
    }

    private function outputMessage(): string
    {
        return "Game created!\n============\nStart guessing by using game:guess + the character you want to try! E.g game:guess a\n";

    }
}
