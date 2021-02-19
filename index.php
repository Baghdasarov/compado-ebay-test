<?php

require_once 'vendor/autoload.php';
require_once 'helpers.php';

use App\FindItemsByKeywords;
use App\FindItemsByKeywordsQuery;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

Debug::enable();

$request = Request::createFromGlobals();

if (!$request->query->has('keywords')) {
    json_response([
        'error' => true,
        'message' => 'keywords parameter is required'
    ], 400);
}

$appId = 'WandoInt-217b-42d8-a699-e79808dd505e';
$searchResults = (new FindItemsByKeywords($appId))->search(FindItemsByKeywordsQuery::fromRequest($request));

json_response([
    'error' => false,
    'data' => $searchResults
]);
