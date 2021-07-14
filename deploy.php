<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'partymeister');

// Project repository
set('repository', 'git@github.com:digitale-kultur/partymeister-template.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);
set('writable_use_sudo', false);
set('writable_chmod_mode', '0775');

// Shared files/dirs between deploys
add('shared_files', [
    '/.env'
]);
add('shared_dirs', [
]);

// Writable dirs by web server
add('writable_dirs', [
    'vendor/motor-cms/motor-core/resources/views'
]);
set('allow_anonymous_stats', false);

// Hosts

host('staging')
    ->hostname('vps.nevoke.eu')
    ->user('deploy')
    ->stage('staging')
    ->set('deploy_path', '/var/www/partymeister/staging');

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.
before('deploy:symlink', 'artisan:migrate');


# due to error message:
# Unable to prepare route [backend/dashboard] for serialization. Another route has already been assigned name [backend.dashboard.index].
task('artisan:optimize', function () {});

task('reload:php-fpm', function () {
    run('sudo /usr/sbin/service php8.0-fpm restart');
});
after('deploy', 'reload:php-fpm');