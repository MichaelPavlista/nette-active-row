<?php declare(strict_types=1);

use Nette\Bridges\CacheDI\CacheExtension;
use Nette\DI\Compiler;
use Nette\DI\Container;
use Nette\Utils\FileSystem;
use Tracy\Debugger;
use Nette\Bridges\DatabaseDI\DatabaseExtension;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap.local.php';

// PHP limits definition.
ini_set(option: 'memory_limit', value: '1024M');
set_time_limit(seconds: 600);

// Create temp directory.
const TMP_DIR = __DIR__ . '/temp';

if (!file_exists(TMP_DIR))
{
    FileSystem::createDir(TMP_DIR);
}

// Tracy activation/deactivation.
Debugger::enable(mode: DEBUG_MODE);

// Nette DI container.
$loader = new Nette\DI\ContainerLoader(tempDirectory: TMP_DIR, autoRebuild: Debugger::isEnabled());

$class = $loader->load(function (Compiler $compiler): void {
    $compiler->addExtension(name: 'cache', extension: new CacheExtension(tempDir: TMP_DIR));
    $compiler->addExtension(name: 'database', extension: new DatabaseExtension(debugMode: DATABASE_DEBUG));
    $compiler->addConfig([
        'database' => [
            'default' => [
                'dsn' => DATABASE_DSN,
                'user' => DATABASE_USER,
                'password' => DATABASE_PASSWORD,
                'options' => [
                    'charset' => 'utf8',
                    'lazy' => 'no',
                ],
                'debugger' => DATABASE_DEBUG,
                'explain' => false,
            ],
        ],
    ]);
});

/** @var Container $container */
$container = new $class;
$container->initialize();

return $container;
