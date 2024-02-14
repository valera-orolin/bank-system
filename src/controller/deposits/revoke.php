<?php
require '../../model/CurrentDate.php';
require '../../model/Account.php';
require '../../model/Deposit.php';
require '../../model/Currency.php';
require '../../model/DepositType.php';
require '../../model/Client.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$id = $_POST['id'];

$deposit_type = Deposit::getDepositType($id);

if (DepositType::getRevocation($deposit_type) != 'revocable') {
    echo "<script>alert('Failed to revoke a deposit. This deposit isn't revocable.'); window.location.href='/controller/deposits/index.php';</script>";
    die();
}

$interest_account = Deposit::getInterestAccount($id);
$current_account = Deposit::getCurrentAccount($id);
$bank_development_fund = Account::getIdByNumber('0000000000002');
$bank_cash_desk = Account::getIdByNumber('0000000000001');

$amount_byn = Deposit::getAmount($id);;
$currency = Deposit::getCurrency($id);
$amount_cur = bcdiv($amount_byn, Currency::getExchangeRate($currency), 8);

Account::withdraw($bank_development_fund, $amount_byn);
Account::deposit($current_account, $amount_cur);
Account::withdraw($current_account, $amount_cur);
Account::deposit($bank_cash_desk, $amount_byn);
Account::withdraw($bank_cash_desk, $amount_byn);

$balance_cur = Account::getBalance($interest_account);
Account::withdraw($interest_account, $balance_cur);
$balance_byn = bcmul($balance_cur, Currency::getExchangeRate($currency), 8);
Account::deposit($bank_cash_desk, $balance_byn);
Account::withdraw($bank_cash_desk, $balance_byn);

Deposit::destroy($id);


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
    $deposit['is_revocable'] = DepositType::getRevocation($deposit['deposit_type']['id']) == 'revocable';
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
