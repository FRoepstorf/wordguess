<?php

declare(strict_types=1);

namespace AE;

use AE\Domain\Shared\PdoConfiguration;

class Configuration
{
    /**
     * @var array
     */
    private $configData;

    public function __construct(array $configData)
    {
        $this->configData = $configData;
    }

    public function wordConfig(): array
    {
        return $this->configData["words"];
    }

    /**
     * Configuration for the pdo_driver (mysql communication)
     */
    public function pdo(): PdoConfiguration
    {
        return new PdoConfiguration($this->configData['pdo']);
    }
}
