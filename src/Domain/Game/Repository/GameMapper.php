<?php

declare(strict_types=1);

namespace AE\Domain\Game\Repository;

use AE\Domain\Game\Game;
use AE\Domain\Game\GuessedChars;
use AE\Domain\Game\WordToGuess;

class GameMapper
{
    /**
     * @var MysqlGameWriter
     */
    private $mysqlGameWriter;
    /**
     * @var MysqlGameLoader
     */
    private $mysqlGameLoader;

    public function __construct(MysqlGameWriter $mysqlGameWriter, MysqlGameLoader $mysqlGameLoader)
    {
        $this->mysqlGameWriter = $mysqlGameWriter;
        $this->mysqlGameLoader = $mysqlGameLoader;
    }

    public function persistNewGame(WordToGuess $wordToGuess, GuessedChars $guessedChars): void
    {
        $this->mysqlGameWriter->persist($wordToGuess, $guessedChars);
    }

    public function persistGuess(Game $game): void
    {
        $this->mysqlGameWriter->persistGuess($game);
    }

    public function deleteGame(): void
    {
        $this->mysqlGameWriter->delete();
    }

    public function game(): Game
    {
        $data = $this->mysqlGameLoader->load();

        return $this->mapGame($data);
    }

    private function mapGame(array $data): Game
    {
        return new Game(
            (int)$data['id'],
            $this->guessedWord($data),
            $this->wordToGuess($data)
        );
    }

    private function guessedWord(array $data): GuessedChars
    {
        return new GuessedChars($data['chars_guessed']);
    }

    private function wordToGuess(array $data): WordToGuess
    {
        return new WordToGuess($data['word_to_guess']);
    }
}
