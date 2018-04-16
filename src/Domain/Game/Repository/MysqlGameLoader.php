<?php

declare(strict_types=1);

namespace AE\Domain\Game\Repository;

use PDO;

class MysqlGameLoader
{
    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function load(): array
    {
        $query = 'SELECT id, word_to_guess, chars_guessed FROM guessed_word';
        $statement = $this->pdo->prepare($query);
        $statement->execute();

        return $statement->fetch();
    }
}
