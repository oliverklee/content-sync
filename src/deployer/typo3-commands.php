<?php

declare(strict_types=1);

namespace Deployer;

use Deployer\Exception\ConfigurationException;

set('bin/typo3', static function (): string {
    if (!get('bin/php')) {
        throw new ConfigurationException('bin/php is empty.', 1_647_874_904);
    }
    if (!get('composer_config/bin-dir')) {
        throw new ConfigurationException('composer_config/bin-dir is empty.', 1_647_874_919);
    }
    if (!get('release_path')) {
        throw new ConfigurationException('release_path is empty.', 1_647_874_946);
    }

    if (test('[ -f {{composer_config/bin-dir}}/typo3 ]')) {
        return '{{bin/php}} {{composer_config/bin-dir}}/typo3';
    }
    if (test('[ -f {{composer_config/bin-dir}}/typo3console ]')) {
        return '{{bin/php}} {{composer_config/bin-dir}}/typo3console';
    }
    if (test('[ -f {{release_path}}/typo3 ]')) {
        return '{{bin/php}} {{release_path}}/typo3';
    }

    throw new ConfigurationException('Cannot determine the TYPO3 Console path.', 1_647_874_954);
});

set('command', '');
set('arguments', []);
task('typo3:console', static function (): void {
    $command = (string)get('command');
    $arguments = get('arguments');
    if (\is_string($arguments)) {
        $arguments = \explode(' ', $arguments);
    }
    output()->writeln(ConsoleRunner::run($command, $arguments));
})->desc('Run any TYPO3 Console command');

task('typo3:flush:caches', static function (): void {
    ConsoleRunner::run('cache:flush');
})->desc('Flush caches');

task('typo3:warmup:caches', static function (): void {
    ConsoleRunner::run('cache:warmup');
})->desc('Warm up caches');

task('typo3:create_default_folders', static function (): void {
    ConsoleRunner::run('install:fixfolderstructure');
})->desc('Creates TYPO3 default folder structure');

task('typo3:update:databaseschema', static function (): void {
    ConsoleRunner::run('database:updateschema');
})->desc('Update database schema');

task('typo3:setup:extensions', static function (): void {
    ConsoleRunner::run('extension:setup');
})->desc('Set up TYPO3 extensions');

task('typo3:upgrade:run', static function (): void {
    ConsoleRunner::run('upgrade:run', ['-n']);
})->desc('Run all upgrade wizards');

// Configuration variables

// fetch `composer.json` and store it in array for later use
set('composer_config', static function () {
    if (!get('source_path')) {
        throw new ConfigurationException('source_path is empty.', 1_647_874_362);
    }

    $composerJsonPath = parse('{{source_path}}/composer.json');
    if (!\file_exists($composerJsonPath)) {
        // If we don't find a `composer.json` file, we assume the root dir to be the release path
        return null;
    }
    return \json_decode(\file_get_contents($composerJsonPath), true, 512, JSON_THROW_ON_ERROR);
});

// extract bin-dir from Composer config
set('composer_config/bin-dir', static function (): string {
    if (!get('release_path')) {
        throw new ConfigurationException('release_path is empty.', 1_647_874_387);
    }

    $binDir = '{{release_path}}/vendor/bin';
    $composerConfig = get('composer_config');
    if (isset($composerConfig['config']['bin-dir'])) {
        $binDir = '{{release_path}}/' . $composerConfig['config']['bin-dir'];
    }
    return $binDir;
});

// extract TYPO3 root dir from Composer config
set('typo3/root_dir', static function (): string {
    // If no config is provided, we assume the root dir to be the release path
    $typo3RootDir = '.';
    $composerConfig = get('composer_config');
    if (isset($composerConfig['extra']['typo3/cms']['web-dir'])) {
        $typo3RootDir = (string)$composerConfig['extra']['typo3/cms']['web-dir'];
    }
    if (isset($composerConfig['extra']['typo3/cms']['root-dir'])) {
        $typo3RootDir = (string)$composerConfig['extra']['typo3/cms']['root-dir'];
    }
    return $typo3RootDir;
});

// extract TYPO3 public directory from composer config
set('typo3/public_dir', static function (): string {
    $composerConfig = get('composer_config');
    if (!isset($composerConfig['extra']['typo3/cms']['web-dir'])) {
        // If no config is provided, we assume the web dir to be the release path
        return '.';
    }
    return (string)$composerConfig['extra']['typo3/cms']['web-dir'];
});
