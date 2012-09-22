<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

require_once __DIR__.'/helper.php';
$app = require_once __DIR__.'/bootstrap.php';

$app->get('/', function() use($app) {
    $posts = json_decode(@file_get_contents(getFilePath()), true);

    return $app['twig']->render('list.html.twig', array(
        'posts' => $posts['values']
    ));
});

$app->get('/post/', function(Request $request) {
    if ($message = createPost($request)) {
        $messages = json_decode(@file_get_contents(getFilePath()), true);
        $messages['values'][uniqid()] = $message;
        @file_put_contents(getFilePath(), json_encode($messages));
    }

    return new RedirectResponse('/');
})->method('POST');

$app->get('/answer/{id}/', function(Request $request, $id) {
        if ($message = createPost($request)) {
            $messages = json_decode(@file_get_contents(getFilePath()), true);
            $messages['values'][$id]['replies'][] = $message;
            @file_put_contents(getFilePath(), json_encode($messages));
        }

        return new RedirectResponse('/');
    })->method('POST');

return $app;