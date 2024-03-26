<?php

declare(strict_types=1);

namespace Deployer;

set('rsync', [
    'exclude' => [],
    'exclude-file' => __DIR__ . '/../../config/deployer/exclude.txt',
    'include' => [],
    'include-file' => false,
    'filter' => [],
    'filter-file' => false,
    'filter-perdir' => false,
    'flags' => 'rz',
    'options' => ['delete', 'delete-excluded', 'links', 'perms', 'times'],
    'timeout' => 300,
]);
set('rsync_src', '{{source_path}}/');

// determine the source path which will be rsynced to the server
set('source_path', static fn(): string => \getcwd());

Deployer::get()->tasks->remove('deploy:update_code');
// https://github.com/deployphp/deployer/blob/master/contrib/rsync.php
task('deploy:update_code', ['rsync'])->desc('Update code via rsync');
