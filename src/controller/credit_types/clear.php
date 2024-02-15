<?php
require '../../model/CreditType.php';
require '../../model/CurrentDate.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

CreditType::clear();
CreditType::store('Кредит «План Б»', 16, 1, 25000, 200000, 360, 1800, 'annuity');
CreditType::store('Автокредит', 16.44, 1, 5000, 200000, 360, 3600, 'differentiated');

$blade = new Blade('../../view', '../../cache');
echo $blade->make('bank.index', [
    'current_date' => CurrentDate::getCurrentDate(),
])->render();
