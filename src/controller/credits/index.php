<?php
require '../../model/Credit.php';
require '../../model/Client.php';
require '../../model/CreditType.php';
require '../../model/Account.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$credits = Credit::all();

foreach ($credits as &$credit) {
    $credit['client'] = [
        'url' => '/',
        'id' => $credit['client'],
        'text' => Client::getClientIdNumber($credit['client']),
    ];
    $credit['credit_type'] = [
        'url' => '/',
        'id' => $credit['credit_type'],
        'text' => CreditType::getCreditTypeName($credit['credit_type']),
    ];
    $credit['current_account'] = [
        'url' => '/',
        'id' => $credit['current_account'],
        'text' => Account::getAccountNumber($credit['current_account']),
    ];
    $credit['interest_account'] = [
        'url' => '/',
        'id' => $credit['interest_account'],
        'text' => Account::getAccountNumber($credit['interest_account']),
    ];
    $credit['payment_schedule'] = [
        'url' => '/controller/credits/payment_schedule.php?creditid=' . $credit['id'],
        //'url' => '/controller/credits/payment_schedule.php',
        'text' => 'Schedule',
    ];
}

$clients = Client::all();
$creditTypes = CreditType::all();
$accounts = Account::all();

$blade = new Blade('../../view', '../../cache');
echo $blade->make('credits.index', [
    'credits' => $credits,
    'clients' => $clients,
    'accounts' => $accounts,
    'creditTypes' => $creditTypes,
])->render();
