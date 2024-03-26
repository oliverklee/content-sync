<?php

declare(strict_types=1);

namespace Deployer;

task('typo3:database:dump', static function (): void {
    $locationOnServer = '/tmp/deployer-db-dump.sql';
    $excludedTables = [
        'be_sessions',
        'be_users',
        'cache_*',
        'fe_sessions',
        'fe_users',
        'static_*',
        'sys_be_shortcuts',
        'sys_history',
        'sys_lockedrecords',
        'sys_log',
        'sys_news',
        'sys_refindex',
        'tx_extensionmanager_*',
        'tx_scheduler_*',
    ];
    $dumpCommand = '{{bin/php}} {{deploy_path}}/current/vendor/bin/typo3 database:export -e ' .
        \implode(' -e ', $excludedTables) . ' > ' . $locationOnServer;
    run($dumpCommand);
    download($locationOnServer, 'var/tmp/deployer-db-dump.sql');
    run('rm ' . $locationOnServer);
})->desc('Dump the database into var/tmp/ on the local machine');
