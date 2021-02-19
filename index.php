<?php

require_once 'vendor/autoload.php';

use App\FindItemsByKeywords;
use App\FindItemsByKeywordsQuery;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

Debug::enable();

$request = Request::createFromGlobals();

if (!$request->query->has('keywords')) {
    $response = new JsonResponse([
        'error' => true,
        'message' => 'keywords parameter is required'
    ], 400);

    $response->send();
    die();
}

(new FindItemsByKeywords())->search(FindItemsByKeywordsQuery::fromRequest($request));
