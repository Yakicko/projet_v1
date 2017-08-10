<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

/******************** FRONT *****************************/



$app->get('/', 'index.controller:indexAction')->bind('homepage');

$app->match('/recipe/create', 'recipe.controller:createAction')->bind('recipe_create');

$app->match('/recipe/list', 'recipe.controller:listAction')->bind('recipe_list');

$app->match('/recipe/index/{id_recipe}', 'recipe.controller:indexAction')->bind('recipe_index');

$app->match('/region/index', 'region.controller:indexAction')->bind('region_index');

$app->match('/region/index/{id_region}', 'region.controller:indexAction')->bind('region_index');



$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
