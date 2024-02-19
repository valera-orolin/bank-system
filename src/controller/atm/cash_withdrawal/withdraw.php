<?php
require '../../../model/CreditCard.php';
require '../../../model/Account.php';
require '../../../model/Currency.php';
require '../../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$number = $_POST['number'] ?? null;
$pin = $_POST['pin'] ?? null;
$amount = $_POST['amount'] ?? null;

$card = CreditCard::authenticate($number, $pin);

if (!$amount) {
    echo "<script>alert('Please enter the amount'); window.location.href='/controller/atm/index.php';</script>";
    die();
}

$blade = new Blade('../../../view', '../../../cache');

if ($card) {
    $current_account = CreditCard::getAccount($card);
    $bank_cash_desk = Account::getIdByNumber('0000000000001');
    $currency = Account::getCurrency($current_account);

    $amount_cur = $amount;
    $amount_byn = bcmul($amount_cur, Currency::getExchangeRate($currency), 8);

    if ($amount_cur > Account::getBalance($current_account)) {
        echo $blade->make('atm.cash_withdrawal', [
            'message' => 'Not enough funds in the account.',
        ])->render();
        die();
    }

    Account::withdraw($current_account, $amount_cur);
    Account::deposit($bank_cash_desk, $amount_byn);
    Account::withdraw($bank_cash_desk, $amount_byn);

    echo $blade->make('atm.result', [
        'message' => $amount_cur . ' ' . Currency::getCurrencySymbol($currency) . ' was cashed out.',
    ])->render();
} else {
    echo $blade->make('atm.not_auth', [
        'message' => 'Invalid PIN code. Try again.',
    ])->render();
}
