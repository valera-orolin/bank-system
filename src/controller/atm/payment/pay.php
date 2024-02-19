<?php
require '../../../model/CreditCard.php';
require '../../../model/Account.php';
require '../../../model/Currency.php';
require '../../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$number = $_POST['number'] ?? null;
$pin = $_POST['pin'] ?? null;
$phone_number = $_POST['phone_number'] ?? null;
$operator = $_POST['operator'] ?? null;
$amount = $_POST['amount'] ?? null;

$card = CreditCard::authenticate($number, $pin);

if (!$amount || !$operator || !$phone_number) {
    echo "<script>alert('Please fill all the fields'); window.location.href='/controller/atm/index.php';</script>";
    die();
}

$blade = new Blade('../../../view', '../../../cache');

if ($card) {
    $current_account = CreditCard::getAccount($card);
    if ($operator == 'A1') {
        $operator_account = Account::getIdByNumber('0000000000003');
    } else if ($operator == 'life') {
        $operator_account = Account::getIdByNumber('0000000000004');
    } else if ($operator == 'MTS') {
        $operator_account = Account::getIdByNumber('0000000000005');
    }
    $currency = Account::getCurrency($current_account);

    $amount_cur = $amount;
    $amount_byn = bcmul($amount_cur, Currency::getExchangeRate($currency), 8);

    if ($amount_cur > Account::getBalance($current_account)) {
        echo $blade->make('atm.payment', [
            'message' => 'Not enough funds in the account.',
        ])->render();
        die();
    }

    Account::withdraw($current_account, $amount_cur);
    Account::deposit($operator_account, $amount_byn);

    echo $blade->make('atm.result', [
        'message' => $amount_cur . ' ' . Currency::getCurrencySymbol($currency) . ' was put on ' . $phone_number . ' number.',
    ])->render();
} else {
    echo $blade->make('atm.not_auth', [
        'message' => 'Invalid PIN code. Try again.',
    ])->render();
}
