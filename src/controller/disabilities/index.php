<?php
require '../../model/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$query = "SELECT * FROM disability";
$params = [];

$disabilities = executeQuery($query, $params);

$blade = new Blade('../../view', '../../cache');
echo $blade->make('disabilities.index', [
    'disabilities' => $disabilities,
])->render();