<?php

namespace Unit\Domain\Game\Repository;


use AE\Domain\Game\Repository\MysqlGameLoader;
use PHPUnit\Framework\TestCase;

/**
 * @covers AE\Domain\Game\Repository\MysqlGameLoader
 */
class MysqlGameLoaderTest extends TestCase
{
    /**
     * @var MysqlGameLoader
     */
    private $gameLoader;

    /**
     * @var \PDO | \PHPUnit_Framework_MockObject_MockObject
     */
    private $pdo;

    /**
     * @var \PDOStatement | \PHPUnit_Framework_MockObject_MockObject
     */
    private $statement;


    protected function setUp()
    {
        $this->statement = $this->createMock(\PDOStatement::class);
        $this->statement->method('execute')->willReturn(true);

        $this->pdo = $this->createMock(\PDO::class);
        $this->pdo->method('prepare')->willReturn($this->statement);
        $this->gameLoader = new MysqlGameLoader($this->pdo);
    }

    public function testCanGetGameData()
    {
        $this->statement->method('fetch')->willReturn($this->data());

        $this->assertSame($this->data(), $this->gameLoader->load());
    }

    private function data(): array
    {
        return [
            "id" => "1",
            "guessed_chars" => "testChars",
            "word_to_guess" => "testWord"
        ];
    }
}
