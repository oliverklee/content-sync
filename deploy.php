<?php

declare(strict_types=1);

namespace Deployer;

import('recipe/common.php');
import('contrib/rsync.php');

import(__DIR__ . '/config/deployer/application.yaml');
import(__DIR__ . '/config/deployer/hosts.yaml');
import(__DIR__ . '/src/deployer/ConsoleRunner.php');
import(__DIR__ . '/src/deployer/database-dump.php');
import(__DIR__ . '/src/deployer/deploy.yaml');
import(__DIR__ . '/src/deployer/logs-pull.php');
import(__DIR__ . '/src/deployer/rsync.php');
import(__DIR__ . '/src/deployer/typo3-commands.php');
import(__DIR__ . '/src/deployer/typo3-configuration.php');
import(__DIR__ . '/src/deployer/uploads-clone.php');
