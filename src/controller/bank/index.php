<?php
require '../../model/City.php';
require '../../model/CurrentDate.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;


$blade = new Blade('../../view', '../../cache');
echo $blade->make('bank.index', [
    'current_date' => CurrentDate::getCurrentDate(),
])->render();
