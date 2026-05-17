<?php

// Vercel memiliki sistem file Read-Only (kecuali folder /tmp).
// Kita paksa Laravel untuk menulis file cache dan view ke folder /tmp.
$compiledViewPath = '/tmp/storage/framework/views';
if (!is_dir($compiledViewPath)) {
    mkdir($compiledViewPath, 0777, true);
}

$_ENV['APP_CONFIG_CACHE'] = '/tmp/config.php';
$_ENV['APP_EVENTS_CACHE'] = '/tmp/events.php';
$_ENV['APP_PACKAGES_CACHE'] = '/tmp/packages.php';
$_ENV['APP_ROUTES_CACHE'] = '/tmp/routes.php';
$_ENV['APP_SERVICES_CACHE'] = '/tmp/services.php';
$_ENV['VIEW_COMPILED_PATH'] = $compiledViewPath;

// Forward Vercel requests to normal Laravel public/index.php
require __DIR__ . '/../public/index.php';
