<?php declare(strict_types=1);

use Tracy\Debugger;

const
    DEBUG_MODE = Debugger::Development,
    BATCH_SIZE = 5_000,

    DATABASE_DSN = 'mysql:host=host.docker.internal;port=3306;dbname=nette-database',
    DATABASE_USER = 'root',
    DATABASE_PASSWORD = 'nette-database',
    DATABASE_DEBUG = true;
