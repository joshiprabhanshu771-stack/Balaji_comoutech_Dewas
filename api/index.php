<?php

/**
 * Balaji Computech - Vercel Serverless Entry Point
 * Normalizes request environment and delegates to CodeIgniter 4 front controller.
 */

// Set Vercel environment marker
putenv('VERCEL=1');
$_ENV['VERCEL'] = '1';
$_SERVER['VERCEL'] = '1';

// Ensure /tmp writable directories exist before framework boots
$tmpWritable = '/tmp/ci4_writable';
if (!is_dir($tmpWritable)) {
    @mkdir($tmpWritable, 0777, true);
}
foreach (['cache', 'logs', 'session', 'uploads', 'debugbar', 'firebase'] as $dir) {
    $subDir = $tmpWritable . '/' . $dir;
    if (!is_dir($subDir)) {
        @mkdir($subDir, 0777, true);
    }
}

// Normalize server variables for CodeIgniter's URI Routing
$_SERVER['DOCUMENT_ROOT']   = realpath(__DIR__ . '/../public');
$_SERVER['SCRIPT_NAME']     = '/index.php';
$_SERVER['PHP_SELF']        = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = realpath(__DIR__ . '/../public/index.php');

// Delegate to standard front controller
require __DIR__ . '/../public/index.php';