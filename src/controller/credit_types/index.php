<?php
require '../../model/CreditType.php';
require '../../model/Currency.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$creditTypes = CreditType::all();

foreach ($creditTypes as &$creditType) {
    $creditType['currency'] = [
        'url' => '/',
        'id' => $creditType['currency'],
        'text' => Currency::getCurrencySymbol($creditType['currency']),
    ];
}

$currencies = Currency::all();

$blade = new Blade('../../view', '../../cache');
echo $blade->make('credit_types.index', [
    'credit_types' => $creditTypes,
    'currencies' => $currencies,
])->render();
