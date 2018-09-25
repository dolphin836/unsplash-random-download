<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/random.php';

use Dolphin\Wang\Unsplash\Random;

$access_key_arr = [
    '',
    ''
];

$dir = __DIR__ . '/../pic';

$random = new Random($access_key_arr, $dir);

$random->run();