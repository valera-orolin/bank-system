<?php
require '../../model/Currency.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$currencies = Currency::all();

$blade = new Blade('../../view', '../../cache');
echo $blade->make('currencies.index', [
    'currencies' => $currencies,
])->render();
