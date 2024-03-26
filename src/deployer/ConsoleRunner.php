<?php

declare(strict_types=1);

namespace Deployer;

use Deployer\Exception\ConfigurationException;

final class ConsoleRunner
{
    public static function run(string $command, array $arguments = []): string
    {
        if (!get('bin/typo3')) {
            throw new ConfigurationException('bin/typo3 is not defined.', 1_647_873_937);
        }
        \array_unshift($arguments, $command);
        return run('{{bin/typo3}} ' . \implode(' ', \array_map('escapeshellarg', $arguments)));
    }
}
