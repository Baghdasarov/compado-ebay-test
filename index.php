<?php

require_once 'vendor/autoload.php';
require_once 'helpers.php';

use App\FindItemsByKeywords;
use App\FindItemsByKeywordsQuery;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\ErrorHandler\Debug;
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

try {
    $searchResults = (new FindItemsByKeywords($appId))->search(FindItemsByKeywordsQuery::fromRequest($request));

    $response = [$searchResults, 200];
} catch (GuzzleException | JsonException $e) {
    $response = [['error' => true], 500];
} finally {
    json_response(...$response);
}
