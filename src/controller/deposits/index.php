<?php
require '../../model/Deposit.php';
require '../../model/Client.php';
require '../../model/DepositType.php';
require '../../model/Account.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$deposits = Deposit::all();

foreach ($deposits as &$deposit) {
    $deposit['client'] = [
        'url' => '/',
        'id' => $deposit['client'],
        'text' => Client::getClientIdNumber($deposit['client']),
    ];
    $deposit['deposit_type'] = [
        'url' => '/',
        'id' => $deposit['deposit_type'],
        'text' => DepositType::getDepositTypeName($deposit['deposit_type']),
    ];
}

$clients = Client::all();
$depositTypes = DepositType::all();
$currentAccounts = Account::all();
$interestAccounts = Account::all();

$blade = new Blade('../../view', '../../cache');
echo $blade->make('deposits.index', [
    'deposits' => $deposits,
    'clients' => $clients,
    'depositTypes' => $depositTypes,
])->render();
