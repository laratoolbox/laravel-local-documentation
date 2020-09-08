<?php

if (PHP_SAPI !== 'cli') {
    die();
}

$versions = [
    'master',
    '8.x',
    '7.x',
    '6.x',
    '5.8',
    '5.7',
    '5.6'
];

$fileList = [];

foreach ($versions as $version) {
    $versionsFolder = __DIR__.'/docs/'.$version;

    echo '--> Branch: '.$version.PHP_EOL.PHP_EOL;

    if (is_dir($versionsFolder)) {
        echo shell_exec("cd $versionsFolder && git pull origin $version");
    } else {
        echo shell_exec("cd '".__DIR__."/docs' && git clone https://github.com/laravel/docs.git --single-branch --branch $version $version");
    }

    $fileList[$version] = array_map('basename', glob("$versionsFolder/*"));

    echo PHP_EOL.str_repeat('-', 60).PHP_EOL.PHP_EOL;
}

file_put_contents(__DIR__.'/files.txt', json_encode($fileList, JSON_PRETTY_PRINT));

echo 'Done!'.PHP_EOL;
