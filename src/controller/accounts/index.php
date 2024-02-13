<?php
require '../../model/Account.php';
require '../../model/Client.php';
require '../../model/Currency.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$accounts = Account::all();

foreach ($accounts as &$account) {
    $account['client'] = [
        'url' => '/',
        'id' => $account['client'],
        'text' => Client::getClientIdNumber($account['client']),
    ];
    $account['currency'] = [
        'url' => '/',
        'id' => $account['currency'],
        'text' => Currency::getCurrencySymbol($account['currency']),
    ];
}

$clients = Client::all();
$currencies = Currency::all();

$blade = new Blade('../../view', '../../cache');
echo $blade->make('accounts.index', [
    'accounts' => $accounts,
    'clients' => $clients,
    'currencies' => $currencies,
])->render();
