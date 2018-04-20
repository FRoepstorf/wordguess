<?php

namespace Unit\Domain\Game;


use AE\Domain\Game\RemainingWordToGuess;
use PHPUnit\Framework\TestCase;

/**
 * @covers AE\Domain\Game\RemainingWordToGuess
 */
class RemainingWordToGuessTest extends TestCase
{

    public function testCanGetRemaingWordToGuess()
    {
        $remainingWord = $this->createRemainingWordToGuess("test");

        $this->assertSame('test', $remainingWord->asString());
    }

    public function testExpectExceptionIfParameterNotSet()
    {
        $this->expectException(\ArgumentCountError::class);
        $this->createRemainingWordToGuess();
    }

    private function createRemainingWordToGuess(string $wordToGuess): RemainingWordToGuess
    {
        return new RemainingWordToGuess($wordToGuess);
    }
}
