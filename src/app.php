<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

$app = require_once __DIR__.'/bootstrap.php';

$app->get('/', function() use($app) {
    $posts = $app['service.post']->all();

    return $app['twig']->render('list.html.twig', array(
        'posts' => $posts['values']
    ));
});

$app->get('/post/', function(Request $request) use($app) {
    $app['service.post']->post($request);

    return new RedirectResponse('/');
})->method('POST');

$app->get('/answer/{id}/', function(Request $request, $id) use($app) {
    $app['service.post']->reply($request, $id);

    return new RedirectResponse('/');
})->method('POST');

return $app;