<?php
include('connect.php');
require_once 'vendor/autoload.php';

// Google Client configuration
$client = new Google_Client();
$client->setClientId('753356832896-1qke4kevrjkltp5ak33ibrthd0qtv0ds.apps.googleusercontent.com');
$client->setClientSecret('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'); 
$client->setRedirectUri('http://localhost/vape/index.php?pg=shop'); 
$client->addScope('email');
$client->addScope('profile');
$client->setPrompt('select_account'); // Prompt for account selection
?>
