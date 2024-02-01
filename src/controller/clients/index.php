<?php
require '../../model/db_functions.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$query = "SELECT * FROM client ORDER BY surname";
$params = [];

$clients = executeQuery($query, $params);

foreach ($clients as &$client) {
    $city_of_residence = executeQuery("SELECT name FROM city WHERE id = ?", [$client['city_of_residence']]);
    $client['city_of_residence'] = [
        'url' => '/',
        'id' => $client['city_of_residence'],
        'text' => $city_of_residence[0]['name'],
    ];

    $registration_city = executeQuery("SELECT name FROM city WHERE id = ?", [$client['registration_city']]);
    $client['registration_city'] = [
        'url' => '/',
        'id' => $client['registration_city'],
        'text' => $registration_city[0]['name'],
    ];

    $marital_status = executeQuery("SELECT name FROM marital_status WHERE id = ?", [$client['marital_status']]);
    $client['marital_status'] = [
        'url' => '/',
        'id' => $client['marital_status'],
        'text' => $marital_status[0]['name'],
    ];

    $citizenship = executeQuery("SELECT name FROM country WHERE id = ?", [$client['citizenship']]);
    $client['citizenship'] = [
        'url' => '/',
        'id' => $client['citizenship'],
        'text' => $citizenship[0]['name'],
    ];

    $disability = executeQuery("SELECT name FROM disability WHERE id = ?", [$client['disability']]);
    $client['disability'] = [
        'url' => '/',
        'id' => $client['disability'],
        'text' => $disability[0]['name'],
    ];
}

$cities = executeQuery("SELECT * FROM city");
$marital_statuses = executeQuery("SELECT * FROM marital_status");
$countries = executeQuery("SELECT * FROM country");
$disabilities = executeQuery("SELECT * FROM disability");

$blade = new Blade('../../view', '../../cache');
echo $blade->make('clients.index', [
    'clients' => $clients,
    'cities' => $cities,
    'marital_statuses' => $marital_statuses,
    'countries' => $countries,
    'disabilities' => $disabilities,
])->render();