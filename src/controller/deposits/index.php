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
    $deposit['current_account'] = [
        'url' => '/',
        'id' => $deposit['current_account'],
        'text' => Account::getAccountNumber($deposit['current_account']),
    ];
    $deposit['interest_account'] = [
        'url' => '/',
        'id' => $deposit['interest_account'],
        'text' => Account::getAccountNumber($deposit['interest_account']),
    ];
}

$clients = Client::all();
$depositTypes = DepositType::all();
$accounts = Account::all();

$blade = new Blade('../../view', '../../cache');
echo $blade->make('deposits.index', [
    'deposits' => $deposits,
    'clients' => $clients,
    'accounts' => $accounts,
    'depositTypes' => $depositTypes,
])->render();
