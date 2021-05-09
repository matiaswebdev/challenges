<?php

require 'vendor/autoload.php';

use \App\CacheService;
use \App\SimpleJsonRequest;

$cacheService = new CacheService(new SimpleJsonRequest());
$cacheService->get('/boat', ['name', 'cleversot']);
