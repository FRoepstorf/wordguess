<?php

declare(strict_types=1);

namespace AE\Domain\Game\Repository;

use AE\Domain\Game\Game;
use AE\Domain\Game\GuessedChars;
use AE\Domain\Game\WordToGuess;
use PDO;

class MysqlGameWriter
{
    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function persist(WordToGuess $wordToGuess, GuessedChars $guessedChars): void
    {
        $query = 'INSERT INTO guessed_word (word_to_guess, chars_guessed) VALUES (:wordToGuess, :charsGuessed)';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('wordToGuess', $wordToGuess->asString());
        $statement->bindValue('charsGuessed', $guessedChars->asString());
        $statement->execute();
    }

    public function persistGuess(Game $game): void
    {
        $query = 'UPDATE guessed_word SET chars_guessed = :charsGuessed WHERE id = :id';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('charsGuessed', $game->guessedChars()->asString());
        $statement->bindValue('id', $game->id());
        $statement->execute();
    }

    public function delete(): void
    {
        $query = "DELETE FROM guessed_word";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
    }
}
