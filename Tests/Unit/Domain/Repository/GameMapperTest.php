<?php

namespace Unit\Domain\Game\Repository;


use AE\Domain\Game\Game;
use AE\Domain\Game\GuessedChars;
use AE\Domain\Game\Repository\GameMapper;
use AE\Domain\Game\Repository\MysqlGameLoader;
use AE\Domain\Game\Repository\MysqlGameWriter;
use AE\Domain\Game\WordToGuess;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * @covers AE\Domain\Game\Repository\GameMapper
 */
class GameMapperTest extends TestCase
{
    /**
     * @var MysqlGameWriter | PHPUnit_Framework_MockObject_MockObject
     */
    private $gameWriter;

    /**
     * @var MysqlGameLoader | PHPUnit_Framework_MockObject_MockObject
     */
    private $gameLoader;

    /**
     * @var GameMapper
     */
    private $gameMapper;

    protected function setUp()
    {
        $this->gameWriter = $this->createMock(MysqlGameWriter::class);
        $this->gameLoader = $this->createMock(MysqlGameLoader::class);
        $this->gameMapper = new GameMapper($this->gameWriter, $this->gameLoader);
    }

    public function testCanGetGame()
    {
        $this->gameLoader->method('load')->willReturn($this->dataArray());

        $this->assertInstanceOf(Game::class, $this->gameMapper->game());
    }

    public function testCanPersistNewGame()
    {
        $wordToGuess = $this->createMock(WordToGuess::class);
        $guessedChars = $this->createMock(GuessedChars::class);

        $this->assertNull($this->gameMapper->persistNewGame($wordToGuess, $guessedChars));
    }

    public function testCanPersistGuess()
    {
        $gameAfterGuess = $this->createMock(Game::class);
        
        $this->assertNull($this->gameMapper->persistGuess($gameAfterGuess));
    }

    public function testCanDeleteGame()
    {
        $this->assertNull($this->gameMapper->deleteGame());
    }

    private function dataArray()
    {
        return [
            "id" => "1",
            "chars_guessed" => 'test',
            "word_to_guess" => 'testWord'
        ];
    }
}
