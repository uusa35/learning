<?php $__container->servers(['localhost' => '127.0.0.1']); ?>

<?php $__container->startMacro('deploy'); ?>
    install
    build
<?php $__container->endMacro(); ?>

<?php $__container->startTask('build'); ?>
    yarn install
<?php $__container->endTask(); ?>

<?php $__container->startTask('install'); ?>
    composer update
<?php $__container->endTask(); ?>

<?php $_vars = get_defined_vars(); $__container->success(function() use ($_vars) { extract($_vars); 
    echo 'You r DONE !!!! :)'
}); ?>
