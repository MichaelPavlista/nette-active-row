<?php declare(strict_types=1);

use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;
use Nette\DI\Container;

/** @var Container $container */
$container = require __DIR__ . '/../bootstrap.php';

/** @var Explorer $databaseExplorer */
$databaseExplorer = $container->getByType(type: Explorer::class);

// Load batch rows from database.
$companyIdToRow = $databaseExplorer->table(table: 'company')
    ->select('*')
    ->order('id DESC')
    ->limit(BATCH_SIZE)
    ->fetchPairs('id');

/** @var ActiveRow $row */
foreach ($companyIdToRow as $row)
{
    // Load related rows.
    $relatedRows = $row->related('company_member')->fetchAll();
}
