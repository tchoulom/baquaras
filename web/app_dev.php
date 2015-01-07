<?php
require_once __DIR__.'/../app/bootstrap.php.cache';
require_once __DIR__.'/../app/AppKernel.php';
require_once __DIR__.'/../app/AppCache.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
// encapsule le AppKernel par défaut avec AppCache
$kernel = new AppCache($kernel);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
