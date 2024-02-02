<?php
require '../../model/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$query = "SELECT * FROM marital_status";
$params = [];

$marital_statuses = executeQuery($query, $params);

$blade = new Blade('../../view', '../../cache');
echo $blade->make('marital_statuses.index', [
    'marital_statuses' => $marital_statuses,
])->render();