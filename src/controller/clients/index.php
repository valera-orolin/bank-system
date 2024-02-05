<?php
require '../../model/Client.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$clients = Client::all();

foreach ($clients as &$client) {
    $client['city_of_residence'] = [
        'url' => '/',
        'id' => $client['city_of_residence'],
        'text' => Client::getCityName($client['city_of_residence']),
    ];

    $client['registration_city'] = [
        'url' => '/',
        'id' => $client['registration_city'],
        'text' => Client::getCityName($client['registration_city']),
    ];

    $client['marital_status'] = [
        'url' => '/',
        'id' => $client['marital_status'],
        'text' => Client::getMaritalStatus($client['marital_status']),
    ];

    $client['citizenship'] = [
        'url' => '/',
        'id' => $client['citizenship'],
        'text' => Client::getCountryName($client['citizenship']),
    ];

    $client['disability'] = [
        'url' => '/',
        'id' => $client['disability'],
        'text' => Client::getDisability($client['disability']),
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