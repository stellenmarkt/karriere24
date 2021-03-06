<?php
namespace Deployer;

require 'recipe/zend_framework.php';

// Project name
set('application', 'karriere24.de');

// Project repository
set('repository', 'git@gitlab.cross-solution.de:HPL/Karriere24.git');

// Shared files/dirs between deploys
add('shared_files', [
    'test/sandbox/public/.htaccess',
    'test/sandbox/public/robots.txt',
]);

add('shared_dirs', [
    'test/sandbox/var/log',
    'test/sandbox/var/cache',
    'test/sandbox/config/autoload',
    'test/sandbox/public/static',	// used by eg. organization logos
]);

// Writable dirs by web server
add('writable_dirs', [
    'test/sandbox/var/cache',
    'test/sandbox/var/log',
    'test/sandbox/public/static',
]);

set('default_stage', 'prod');

// Hosts

host('upcoming.karriere24.de')
    ->user('yawik')
    ->stage('prod')
    ->multiplexing(false)
    ->set('deploy_path', '/var/www/production')
    ->set('writableusesudo', true);

host('staging.karriere24.com')
    ->user('yawik')
    ->stage('staging')
    ->multiplexing(false)
    ->set('deploy_path', '/var/www/production')
    ->set('writableusesudo', true);

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

