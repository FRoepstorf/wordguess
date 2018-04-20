<?php

namespace Unit\Domain\Shared;


use AE\Domain\Shared\PdoConfiguration;
use PHPUnit\Framework\TestCase;

/**
 * @covers AE\Domain\Shared\PdoConfiguration
 */
class PdoConfigurationTest extends TestCase
{
    /**
     * @var PdoConfiguration
     */
    private $pdoConfiguration;

    protected function setUp()
    {
        $this->pdoConfiguration = new PdoConfiguration($this->data());
    }

    public function testCanGetUserName()
    {
        $this->assertSame('testUsername', $this->pdoConfiguration->username());
    }

    public function testCanGetPassword()
    {
        $this->assertSame('testPassword', $this->pdoConfiguration->password());
    }

    public function testCanGetDatabase()
    {
        $this->assertSame('testDatabase', $this->pdoConfiguration->database());
    }

    public function testCanGetHost()
    {
        $this->assertSame('testHost', $this->pdoConfiguration->host());
    }

    private function data(): array
    {
        return [
            "host" => "testHost",
            "username" => "testUsername",
            "password" => "testPassword",
            "database" => "testDatabase"
        ];
    }
}
