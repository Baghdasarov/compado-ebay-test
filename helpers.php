<?php

use Symfony\Component\HttpFoundation\JsonResponse;

function json_response(array $data, int $code = 200): void
{
    $response = new JsonResponse($data, $code);

    $response->send();
    die();
}
