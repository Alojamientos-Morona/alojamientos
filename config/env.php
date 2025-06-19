<?php
use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php'; // Composer autoload

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
