#!/usr/bin/env php
<?php

namespace AE;

require __DIR__ . "/vendor/autoload.php";

use Symfony\Component\Console\Application;

$configData = require __DIR__ . "/app-config.php";

$configuration = new Configuration($configData);

$factory = new Factory($configuration);

$application = new Application();

$application->add($factory->createGameCommand());
$application->add($factory->createGuessCommand());

$application->run();
