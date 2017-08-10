<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...

    return $twig;
});

// Ajout doctrine DBAL ($app['db'])
// Nécessite l'installation par composer : composer require doctrine/dbal:~2.2
// en ligne de commande dans le repertoire de l'application
$app->register(new DoctrineServiceProvider(),
    [
        'db.options'    => [
            'driver'    => 'pdo_mysql',
            'host'      => 'localhost',
            'dbname'    => 'projet_v1',
            'user'      => 'root',
            'password'  => '',
            'charset'   => 'utf8'
        ]
    ]);

// $app['session'] = gestionnaire de session de symfony
$app->register(new Silex\Provider\SessionServiceProvider());

$app['recipe.controller'] = function () use ($app)
{
    return new \Controller\RecipeController($app);
};

$app['recipe.repository'] = function () use ($app)
{
    return new \Repository\RecipeRepository($app);
};

return $app;
