<?php

declare(strict_types=1);

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Symfony\Component\Dotenv\Dotenv;

function loadDotenv(): void
{
    if (file_exists($env = __DIR__ . '/.env')) {
        $dotenv = new Dotenv();
        $dotenv->load($env);
    }
}

loadDotenv();

function info(string $message = 'info', array $context = []): void
{
    $log = new Logger('info');
    $log->pushHandler(new StreamHandler(LOGDIR . '/info.log', Level::Notice));
    $log->notice('info', ['name' => 'Felipe']);
}

function error(string $message = 'error', array $context = []): void
{
    $log = new Logger('error');
    $log->pushHandler(new StreamHandler(LOGDIR . '/error.log', Level::Error));

    $log->notice('error', ['this crashed']);
}
