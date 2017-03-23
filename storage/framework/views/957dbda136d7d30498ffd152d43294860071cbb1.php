<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Sign Here')); ?></title>

    <!-- Styles and Script -->
    <?php echo $__env->make('layouts.asset', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</head>
<body>
    <div id="app">
        <div class="row">
            <div>
                <?php $__env->startSection('header'); ?>
                    <?php echo $__env->make('layouts.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php echo $__env->yieldSection(); ?>
            </div>
        </div>
        <div class="row">
            <?php $__env->startSection('menu'); ?>
                <?php if(Auth::check()): ?>
                    <div id="colsx"><br>
                        <p>Admin</p><ul class='nav navbar-nav'><li class='nav-divider'></li><li class='dropdown'><a href='#'  class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>Admin<span class='caret'></span></a></li><ul class='dropdown-menu' role='menu'><li><a href='http://localhost:8000/admin' role='button' aria-expanded='false'>Admin</a></li><li><a href='http://localhost:8000/Voce A' role='button' aria-expanded='false'>menu.Voce A</span></a></li><li><a href='http://localhost:8000/Voce B' role='button' aria-expanded='false'>menu.Voce B</span></a></li><li><a href='http://localhost:8000/Voce C' role='button' aria-expanded='false'>menu.Voce C</span></a></li><li><a href='http://localhost:8000/Voce D' role='button' aria-expanded='false'>menu.Voce D</span></a></li></ul></ul><br>
                    </div>
                <?php endif; ?>
            <?php echo $__env->yieldSection(); ?>

            <?php if(Auth::check()): ?>
                <div id="coldx">
            <?php else: ?>
                <div id="coldx">
            <?php endif; ?>
                    <div class="row">
                        <div id="alert">
                            <?php if(Session::has('message')): ?>
                                <div class="alert alert-info"><?php echo e(ucfirst(Session::get('message').'  '.$errors->first())); ?></div>
                                <?php Session::remove('message'); ?>
                            <?php endif; ?>
                            <?php if(Session::has('alert')): ?>
                                <div class="alert alert-danger"><?php echo e(ucfirst(Session::get('alert').'  '.$errors->first())); ?></div>
                                <?php Session::remove('alert'); ?>
                            <?php endif; ?>
                            <?php if(Session::has('success')): ?>
                                <div class="alert alert-success"><?php echo e(ucfirst(Session::get('success').'  '.$errors->first())); ?></div>
                                <?php Session::remove('success'); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
        </div>
        <div class="row">
            <?php echo $__env->make('layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
    </div>
    <?php echo $__env->make('layouts.script', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</body>
</html>
