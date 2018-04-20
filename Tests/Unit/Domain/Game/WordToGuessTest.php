<?php

namespace Unit\Domain\Game;


use AE\Domain\Game\WordToGuess;
use PHPUnit\Framework\TestCase;

/**
 * @covers AE\Domain\Game\WordToGuess
 */
class WordToGuessTest extends TestCase
{
    public function testCanGetWordToGuessAsString()
    {
        $wordToGuess = $this->createWordToGuess('test');

        $this->assertSame('test', $wordToGuess->asString());
    }

    public function testExpectExceptionIfParamterNotSet()
    {
        $this->expectException(\ArgumentCountError::class);
        $this->createWordToGuess();
    }

    private function createWordToGuess(string $wordToGuess): WordToGuess
    {
        return new WordToGuess($wordToGuess);
    }
}
