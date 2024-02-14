<?php
require '../../model/CurrentDate.php';
require '../../model/Account.php';
require '../../model/Deposit.php';
require '../../model/Currency.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$deposits = Deposit::all();
foreach ($deposits as $deposit) {
    $rate = Deposit::getRate($deposit['id']);
    $amount = Deposit::getAmount($deposit['id']);
    $currency = Deposit::getCurrency($deposit['id']);
    $interest = bcdiv(bcdiv(bcmul($amount, $rate, 8), '365', 8), '100', 8);

    $interest_account = $deposit['interest_account'];
    $bank_development_fund = Account::getIdByNumber('0000000000002');

    $withdraw_amount = bcdiv($interest, Currency::getExchangeRate($currency), 8);
    Account::withdraw($bank_development_fund, $withdraw_amount);
    Account::deposit($interest_account, $interest);
}

CurrentDate::incrementDate();

$blade = new Blade('../../view', '../../cache');
echo $blade->make('bank.index', [
    'current_date' => CurrentDate::getCurrentDate(),
])->render();
