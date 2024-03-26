<?php

declare(strict_types=1);

namespace Deployer;

task('typo3:fileadmin:clone', static function (): void {
    $folder = 'public/fileadmin/';
    $filesOnServer = '{{deploy_path}}/current/' . $folder . '*';
    $localFolder = $folder;
    download($filesOnServer, $localFolder);
})->desc('Clones the fileadmin folder from the live site');
