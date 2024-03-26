<?php

declare(strict_types=1);

namespace Deployer;

task('typo3:database:push', static function (): void {
    $locationOnServer = '/tmp/deployer-db-dump.sql';
    upload('var/tmp/deployer-db-dump.sql', $locationOnServer);
    $importCommand = '{{bin/php}} {{deploy_path}}/current/vendor/bin/typo3 database:import < ' . $locationOnServer;
    run($importCommand);
    run('rm ' . $locationOnServer);
})->desc('Pushes the existing DB dump from local var/tmp/ to the remote machine and imports it there');
