<?php
require '../../model/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$query = "SELECT * FROM city";
$params = [];

$cities = executeQuery($query, $params);

$blade = new Blade('../../view', '../../cache');
echo $blade->make('cities.index', [
    'cities' => $cities,
])->render();