<?php
header('Content-Type: text/plain');
echo "__DIR__=" . __DIR__ . "\n";
echo "file_exists=" . (file_exists(__DIR__ . '/../vendor/autoload.php') ? 'yes' : 'no') . "\n";
echo "is_readable=" . (is_readable(__DIR__ . '/../vendor/autoload.php') ? 'yes' : 'not-readable') . "\n";
echo "realpath=" . (realpath(__DIR__ . '/../vendor/autoload.php') ?: 'none') . "\n";
