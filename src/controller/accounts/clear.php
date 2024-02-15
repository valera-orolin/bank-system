<?php
require '../../model/Account.php';
require '../../model/CurrentDate.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

Account::clear();
Account::store('0000000000001', '1010', 'active', 0, 0, 0, null, 1);
Account::store('0000000000002', '7327', 'passive', 0, 100000000000, 100000000000, null, 1);

$blade = new Blade('../../view', '../../cache');
echo $blade->make('bank.index', [
    'current_date' => CurrentDate::getCurrentDate(),
])->render();
