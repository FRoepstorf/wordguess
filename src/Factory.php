<?php

declare(strict_types=1);

namespace AE\Application;

use AE\Commands\CreateGameCommand;
use AE\Commands\GameCommandParameters;
use AE\Commands\GuessCommand;
use AE\Domain\Game\Game;
use AE\Domain\Game\GuessedChars;
use AE\Domain\Game\RemainingWordToGuess;
use AE\Domain\Game\Repository\GameMapper;
use AE\Domain\Game\Repository\MysqlGameLoader;
use AE\Domain\Game\Repository\MysqlGameWriter;
use AE\Domain\Game\WordToGuess;
use PDO;

class Factory
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function createWordToGuess()
    {
        return new WordToGuess($this->getRandomWord());
    }

    public function createEmptyGuessedChars(): GuessedChars
    {
        return new GuessedChars('');
    }

    public function createGame(int $id, string $guessedChars, string $wordToGuess, string $remainingWordsToGuess): Game
    {
        return new Game(
            $id,
            new GuessedChars($guessedChars),
            new WordToGuess($wordToGuess),
            new RemainingWordToGuess($remainingWordsToGuess)
        );
    }

    public function createGameCommand()
    {
        return new CreateGameCommand(
            $this->createGameMapper(),
            $this->createGameCommandParameters()
        );
    }

    public function createGuessCommand(): GuessCommand
    {
        return new GuessCommand(
            $this->createGameMapper(),
            $this->createGameCommandParameters()
        );
    }

    /**
     * Creates the PDO class that wraps the communication with the mysql database.
     * It only creates it, if there is no Instantiation of it yet.
     */
    private function createPdo()
    {
        if (null === $this->pdo) {
            $dsn = sprintf(
                'mysql:host=%s;PORT=3306;dbname=%s;charset=UTF8',
                $this->configuration->pdo()->host(),
                $this->configuration->pdo()->database()
            );
            $this->pdo = new PDO(
                $dsn,
                $this->configuration->pdo()->username(),
                $this->configuration->pdo()->password()
            );
        }
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $this->pdo;
    }

    private function getRandomWord(): string
    {
        $wordArray = $this->configuration->wordConfig();
        return $wordArray[array_rand($wordArray)];
    }

    private function createGameMapper(): GameMapper
    {
        return new GameMapper(
            $this->createMysqlGameWriter(),
            $this->createMysqlGameLoader()
        );
    }

    private function createMysqlGameWriter(): MysqlGameWriter
    {
        return new MysqlGameWriter($this->createPdo());
    }

    private function createMysqlGameLoader(): MysqlGameLoader
    {
        return new MysqlGameLoader($this->createPdo());
    }

    private function createGameCommandParameters(): GameCommandParameters
    {
        return new GameCommandParameters($this);
    }
}
