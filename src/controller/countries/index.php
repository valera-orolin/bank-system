<?php
require '../../model/Country.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$countries = Country::all();

$blade = new Blade('../../view', '../../cache');
echo $blade->make('countries.index', [
    'countries' => $countries,
])->render();