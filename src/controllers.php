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


$app
    ->match('/utilisateur/inscription', 'user.controller:registerAction')
    ->bind('user_register')
;

$app
    ->match('/utilisateur/connexion', 'user.controller:loginAction')
    ->bind('user_login')
;

$app
    ->match('/utilisateur/deconnexion', 'user.controller:logoutAction')
    ->bind('user_logout')
;
/******************** BACK ******************************/

// créé un groupe de routes
$admin = $app['controllers_factory'];

// Pour toutes les routes du groupe, si on n'est
// pas connecté en admin, page 403
$admin->before(function () use ($app){
    if(!$app['user.manager']->isAdmin()){
        $app->abort(403, 'Acces refusé');
    }
});

$app->mount('/admin', $admin);

    //-------------- USER
$admin
    ->get('/utilisateurs', 'admin.user.controller:listAction')
    ->bind('admin_users')
;

$admin
    ->match('/utilisateur/edition/{id_user}', 'admin.user.controller:editAction')
    ->value('id_user', null) // valeur par défaut pour l'id
    ->bind('admin_user_edit')
;

$admin
    ->get('/utilisateur/suppression/{id_user}', 'admin.user.controller:deleteAction')
    ->assert('id_user','\d+') // id doit être un nombre  
    ->bind('admin_user_delete')
;

    //------------- RECIPE
$admin
    ->get('/recettes', 'admin.recipe.controller:listAction')
    ->bind('admin_recipes')
;

$admin
    ->get('/recette/suppression/{id_recipe}', 'admin.recipe.controller:deleteAction')
    ->assert('id_recipe','\d+') // id doit être un nombre  */
    ->bind('admin_recipe_delete')
;

    //------------- REGION
$admin
    ->get('/regions', 'admin.region.controller:listAction')
    ->bind('admin_regions')
;

$admin
    ->match('/region/edition/{id_region}', 'admin.region.controller:editAction')
    ->value('id_region', null) // valeur par défaut pour l'id
    ->bind('admin_region_edit')
;

$admin
    ->get('/region/suppression/{id_region}', 'admin.region.controller:deleteAction')
    ->assert('id_region','\d+') // id doit être un nombre
    ->bind('admin_region_delete')
;












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
