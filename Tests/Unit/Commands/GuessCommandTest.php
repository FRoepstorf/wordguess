<?php

namespace Unit\Commands;

use AE\Commands\GameCommandParameters;
use AE\Commands\GuessCommand;
use AE\Domain\Game\Game;
use AE\Domain\Game\RemainingWordToGuess;
use AE\Domain\Game\Repository\GameMapper;
use AE\Domain\Game\WordToGuess;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @covers AE\Commands\GuessCommand
 */
class GuessCommandTest extends TestCase
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
     * @var GuessCommand
     */
    private $guessCommand;

    /**
     * @var CommandTester
     */
    private $commandTester;

    protected function setUp()
    {
        $this->gameMapper = $this->createMock(GameMapper::class);
        $this->commandParameters = $this->createMock(GameCommandParameters::class);
        $this->guessCommand = new GuessCommand($this->gameMapper, $this->commandParameters);
        $application = new Application();
        $application->add($this->guessCommand);
        $command = $application->find('game:guess');
        $this->commandTester = new CommandTester($command);
    }

    public function testCanContinueGuessing()
    {
        $gameBefore = $this->createMock(Game::class);
        $wordToGuess = $this->createMock(WordToGuess::class);
        $wordToGuess->method('asString')->willReturn('test');
        $gameBefore->method('wordToGuess')->willReturn($wordToGuess);
        $remainingWordtoGuessBefore = $this->createMock(RemainingWordToGuess::class);
        $remainingWordtoGuessBefore->method('asString')->willReturn('nope');
        $remainingWordToGuessAfter = $this->createMock(RemainingWordToGuess::class);
        $remainingWordToGuessAfter->method('asString')->willReturn('nop_');
        $gameBefore->method('remainingWordtoGuess')->willReturn($remainingWordtoGuessBefore);
        $gameAfter = $this->createMock(Game::class);
        $gameAfter->method('remainingWordToGuess')->willReturn($remainingWordToGuessAfter);
        $this->commandParameters->method('createGameAfterGuess')
                                ->willReturn($gameAfter);
        $this->gameMapper->method('game')
                         ->willReturn($gameBefore);
        $this->gameMapper->expects($this->once())
                         ->method('persistGuess');

        $this->commandTester->execute([
            "command" => $this->guessCommand->getName(),
            "guess" => 'a'
        ]);

        $this->assertSame("nop_\nContinue to guess the word!\n", $this->commandTester->getDisplay());
    }

    public function testCanWinGame()
    {
        $gameBefore = $this->createMock(Game::class);
        $wordToGuess = $this->createMock(WordToGuess::class);
        $wordToGuess->method('asString')->willReturn('test');
        $remainingWordtoGuessBefore = $this->createMock(RemainingWordToGuess::class);
        $remainingWordtoGuessBefore->method('asString')->willReturn('test');
        $remainingWordToGuessAfter = $this->createMock(RemainingWordToGuess::class);
        $remainingWordToGuessAfter->method('asString')->willReturn('test');
        $gameBefore->method('remainingWordToGuess')->willReturn($remainingWordtoGuessBefore);
        $gameAfter = $this->createMock(Game::class);
        $gameAfter->method('remainingWordToGuess')->willReturn($remainingWordToGuessAfter);
        $gameAfter->method('wordToGuess')->willReturn($wordToGuess);
        $this->commandParameters->method('createGameAfterGuess')
            ->willReturn($gameAfter);
        $this->gameMapper->method('game')
                         ->willReturn($gameBefore);
        $this->gameMapper->expects($this->once())
                         ->method('deleteGame');

        $this->commandTester->execute([
            "command" => $this->guessCommand->getName(),
            "guess" => 'a'
        ]);

        $this->assertSame("Correct! Thanks for playing!\n", $this->commandTester->getDisplay());
    }

}
