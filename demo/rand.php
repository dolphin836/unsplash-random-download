<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/random.php';

use Dolphin\Wang\Unsplash\Random;

$access_key_arr = [
    'b98fc10777cea951e97eecc7edb46a37d0681d7d290319d048e40157b758c05f'
];

$dir = __DIR__ . '/../pic';

$random = new Random($access_key_arr, $dir);

var_dump($random->rand());