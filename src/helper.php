<?php

use Symfony\Component\HttpFoundation\Request;

/**
 * @return string
 */
function getFilePath() {
    return __DIR__.'/../data/posts.json';
}

/**
 * @param Symfony\Component\HttpFoundation\Request $request
 * @return array|null
 */
function createPost(Request $request) {
    $value = trim($request->get('message'));

    if ($value) {
        $now = new DateTime();

        return array(
            'timestamp' => $now->format('d.m.Y H:i'),
            'value' => strip_tags($value)
        );
    }

    return null;
}