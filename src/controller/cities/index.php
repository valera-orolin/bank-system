<?php
require '../../model/City.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$cities = City::all();

$blade = new Blade('../../view', '../../cache');
echo $blade->make('cities.index', [
    'cities' => $cities,
])->render();
