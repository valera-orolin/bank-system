<?php
require '../../model/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$query = "SELECT * FROM country";
$params = [];

$countries = executeQuery($query, $params);

$blade = new Blade('../../view', '../../cache');
echo $blade->make('countries.index', [
    'countries' => $countries,
])->render();