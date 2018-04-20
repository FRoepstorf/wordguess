<?php

namespace Unit\Domain\Game;


use AE\Domain\Game\GuessedChars;
use ArgumentCountError;
use PHPUnit\Framework\TestCase;

/**
 * @covers AE\Domain\Game\GuessedChars
 */
class GuessedCharsTest extends TestCase
{

    public function testCanCreateGuessedChars()
    {
        $this->assertInstanceOf(GuessedChars::class, $this->createGuessedChars('test'));
    }

    public function testCanGetGuessedCharsAsString()
    {
        $guessedChars = $this->createGuessedChars('test');
        $this->assertSame('test', $guessedChars->asString());
    }

    public function testCanNotLeaveParameterBlank()
    {
        $this->expectException(ArgumentCountError::class);
        $this->createGuessedChars();
    }

    private function createGuessedChars(string $guessedchars): GuessedChars
    {
        return new GuessedChars($guessedchars);
    }
}
