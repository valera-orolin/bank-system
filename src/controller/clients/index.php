<?php
require '../../model/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$query = "SELECT * FROM client";
$params = [];

$clients = executeQuery($query, $params);

$blade = new Blade('../../view', '../../cache');
echo $blade->make('clients.index', ['clients' => $clients])->render();