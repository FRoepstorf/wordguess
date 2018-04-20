<?php

namespace Unit\Domain\Game\Repository;


use AE\Domain\Game\Game;
use AE\Domain\Game\GuessedChars;
use AE\Domain\Game\Repository\MysqlGameWriter;
use AE\Domain\Game\WordToGuess;
use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;

/**
 * @covers AE\Domain\Game\Repository\MysqlGameWriter
 */
class MysqlGameWriterTest extends TestCase
{
    /**
     * @var PDO | \PHPUnit_Framework_MockObject_MockObject
     */
    private $pdo;

    /**
     * @var PDOStatement | \PHPUnit_Framework_MockObject_MockObject
     */
    private $statement;

    /**
     * @var MysqlGameWriter
     */
    private $gameWriter;

    protected function setUp()
    {
        $this->pdo = $this->createMock(PDO::class);
        $this->statement = $this->createMock(PDOStatement::class);
        $this->statement->method('execute')->willReturn(true);
        $this->statement->method('bindValue')->willReturn(true);
        
        $this->pdo->method('prepare')->willReturn($this->statement);
        $this->gameWriter = new MysqlGameWriter($this->pdo);
    }

    public function testCanPersistNewGame()
    {
        $wordToGuess = $this->createMock(WordToGuess::class);
        $guessedChars = $this->createMock(GuessedChars::class);
        
        $this->assertNull($this->gameWriter->persist($wordToGuess, $guessedChars));
    }

    public function testCanPersistGuess()
    {
        $game = $this->createMock(Game::class);

        $this->assertNull($this->gameWriter->persistGuess($game));
    }

    public function testCanDeleteGame()
    {
        $this->assertNull($this->gameWriter->delete());
    }
}
