<?php

require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
// use Intervention\Image\ImageManagerStatic as Image;
// use Cloudinary\Cloudinary;
// $cloudinary = new Cloudinary(
//     [
//         'cloud' => [
//             'cloud_name' => 'dyn4nexb0',
//             'api_key'    => '819175155546639',
//             'api_secret' => 'pXH_jkaQUJf7aHL4gVKd7VUb11g',
//         ],
//     ]
// );

// require 'functions.php';
require 'config/database.php';
// ini_set('upload_max_filesize', '10M');

?>