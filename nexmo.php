<?php
require_once "vendor/autoload.php";
const NEXMO_API_KEY = 'dab45f2c';
const NEXMO_API_SECRET = '328110bb717a66c3';
$basic  = new \Nexmo\Client\Credentials\Basic(NEXMO_API_KEY, NEXMO_API_SECRET);
$client = new \Nexmo\Client($basic);
