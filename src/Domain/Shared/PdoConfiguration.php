<?php

declare(strict_types=1);

namespace AE\Domain\Shared;

class PdoConfiguration
{
    /**
     * @var array
     */
    private $configData;

    public function __construct(array $configData)
    {
        $this->configData = $configData;
    }

    public function host(): string
    {
        return $this->configData['host'];
    }

    public function database(): string
    {
        return $this->configData['database'];
    }

    public function username()
    {
        return $this->configData['username'];
    }

    public function password(): string
    {
        return $this->configData['password'];
    }
}
