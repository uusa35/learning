@servers(['localhost' => '127.0.0.1'])

@story('deploy-local', ['on' => 'localhost'])
    install
    build
@endstory

@story('deploy-production', ['on' => 'localhost'])
    print-text
@endstory

@task('build')
    yarn install
@endtask

@task('install')
    composer update
@endtask

@task('print-text')
    echo 'this is production commands';
@endtask

@success
    echo 'You r DONE !!!! :)';
@endsuccess
