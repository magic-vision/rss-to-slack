<?php

require __DIR__."/vendor/autoload.php";

use Symfony\Component\Console\Application;


\Symfony\Component\Debug\Debug::enable();
$application = new Application();
$command = new \Rts\RssToSlackCommand();
$command->setConfig(require __DIR__."/config.php");
$application->add($command);
$application->setDefaultCommand($command->getName());
$application->run();
