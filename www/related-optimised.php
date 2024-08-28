<?php declare(strict_types=1);

use Nette\Database\Explorer;
use Nette\DI\Container;

/** @var Container $container */
$container = require __DIR__ . '/../bootstrap.php';

/** @var Explorer $databaseExplorer */
$databaseExplorer = $container->getByType(type: Explorer::class);

// Select main rows.
$companyIdToRow = $databaseExplorer
    ->query('SELECT * FROM `company` ORDER BY `id` DESC LIMIT ?', BATCH_SIZE)
    ->fetchPairs('id');

// Create main rows ID list.
$companyIdList = array_keys($companyIdToRow);

// Select rows from the related table.
$companyIdToMemberRowList = $databaseExplorer
    ->query('SELECT `id`, `company_id` FROM `company_member` WHERE `company_id` IN (?)', $companyIdList)
    ->fetchAssoc('company_id[]->');

foreach ($companyIdToRow as $row)
{
    // Load related rows.
    $relatedRows = $companyIdToMemberRowList[$row['id']] ?? [];
}
