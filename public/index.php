<?php

declare(strict_types=1);

define('LOGDIR', dirname(__DIR__) . '/storage/logs/');

session_start();

require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/../support/helper.php';

require __DIR__ . '/../bootstrap.php';

require __DIR__ . '/../routes/web.php';
