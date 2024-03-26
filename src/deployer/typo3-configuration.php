<?php

declare(strict_types=1);

namespace Deployer;

// unset env vars that affect build process
unset(
    $_ENV['TYPO3_CONTEXT'],
    $_ENV['TYPO3_PATH_ROOT'],
    $_ENV['TYPO3_PATH_WEB'],
    $_ENV['TYPO3_PATH_COMPOSER_ROOT'],
    $_ENV['TYPO3_PATH_APP']
);
\putenv('TYPO3_CONTEXT');
\putenv('TYPO3_PATH_ROOT');
\putenv('TYPO3_PATH_WEB');
\putenv('TYPO3_PATH_COMPOSER_ROOT');
\putenv('TYPO3_PATH_APP');

// Config

set('shared_files', ['.env']);
set('shared_dirs', [
    '{{typo3/root_dir}}/fileadmin',
    'var/charset',
    'var/lock',
    'var/log',
    'var/session',
    'var/spool/mail',
]);
set('writable_dirs', []);
