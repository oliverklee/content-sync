<?php

declare(strict_types=1);

namespace Deployer;

task('typo3:logs:pull', static function (): void {
    $filesOnServer = '{{deploy_path}}/shared/var/log/*';
    $localFolder = 'var/log/production/';
    download($filesOnServer, $localFolder);
})->desc('Copies the log files from the live site');
