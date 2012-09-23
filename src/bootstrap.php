<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/QA/Service/PostService.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app['service.post'] = $app->share(function() {
    return new \QA\Service\PostService(__DIR__.'/../data/posts.json');
});

return $app;