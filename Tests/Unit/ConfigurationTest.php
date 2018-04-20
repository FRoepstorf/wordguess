<?php

namespace Unit;


use AE\Configuration;
use AE\Domain\Shared\PdoConfiguration;
use PHPUnit\Framework\TestCase;

/**
 * @covers \AE\Configuration
 */
class ConfigurationTest extends TestCase
{
    /**
     * @var Configuration
     */
    private $configuration;

    protected function setUp()
    {
        $this->configuration = new Configuration($this->data());
    }

    public function testCanGetPdoConfiguration()
    {
        $this->assertInstanceOf(PdoConfiguration::class, $this->configuration->pdo());
    }

    public function testCanGetWordconfig()
    {
        $this->assertSame($this->wordConfig(), $this->configuration->wordConfig());
    }

    private function data(): array
    {
        return [
            "words" => $this->wordConfig(),
            "pdo" => [
                "host" => "testHost",
                "username" => "testUsername",
                "password" => "testPassword",
                "database" => "testDatabase"
            ]
        ];
    }

    private function wordConfig(): array
    {
        return [
            "test",
            "test1"
        ];
    }
}
