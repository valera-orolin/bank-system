<?php
require '../../model/DepositType.php';
require '../../model/Currency.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$depositTypes = DepositType::all();

foreach ($depositTypes as &$depositType) {
    $depositType['currency'] = [
        'url' => '/',
        'id' => $depositType['currency'],
        'text' => DepositType::getCurrencySymbol($depositType['currency']),
    ];
}

$currencies = Currency::all();

$blade = new Blade('../../view', '../../cache');
echo $blade->make('deposit_types.index', [
    'deposit_types' => $depositTypes,
    'currencies' => $currencies,
])->render();
