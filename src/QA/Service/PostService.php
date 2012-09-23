<?php

namespace QA\Service;

use Symfony\Component\HttpFoundation\Request;
use DateTime;

class PostService
{
    private $filepath;

    /**
     * @param string $filepath
     */
    public function __construct($filepath) {
        $this->filepath = $filepath;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function post(Request $request)
    {
        if ($message = $this->make($request)) {
            $messages = $this->all();
            $messages['values'][uniqid()] = $message;
            $this->persist($messages);
        }
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param $id
     */
    public function reply(Request $request, $id)
    {
        if ($message = $this->make($request)) {
            $messages = $this->all();
            $messages['values'][$id]['replies'][] = $message;
            $this->persist($messages);
        }
    }

    /**
     * @return array
     */
    public function all()
    {
        return json_decode(@file_get_contents($this->filepath), true);
    }

    /**
     * @param array $messages
     */
    private function persist(array $messages)
    {
        @file_put_contents($this->filepath, json_encode($messages));
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return array|null
     */
    private function make(Request $request)
    {
        if ($value = trim($request->get('message'))) {
            $now = new DateTime();

            return array(
                'timestamp' => $now->format('d.m.Y H:i'),
                'value' => strip_tags($value)
            );
        }

        return null;
    }
}
