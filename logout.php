<?php

require_once __DIR__ . '/vendor/autoload.php';

setcookie('X-JWT-SESSION','logout');
header("Location: /login.php");
