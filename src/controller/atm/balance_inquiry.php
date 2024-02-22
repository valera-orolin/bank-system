<?php
require '../../model/CreditCard.php';
require '../../model/Account.php';
require '../../model/Currency.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$number = $_POST['number'] ?? null;
$pin = $_POST['pin'] ?? null;

$blade = new Blade('../../view', '../../cache');

try {
    $card = CreditCard::authenticate($number, $pin);
} catch (Exception $e) {
    echo $blade->make('atm.not_auth', [
        'message' => $e->getMessage(),
    ])->render();
    die();
}

if ($card) {
    $account = CreditCard::getAccount($card);
    $balance = Account::getBalance($account);
    $currency = Currency::getCurrencySymbol(Account::getCurrency($account));
    echo $blade->make('atm.result', [
        'message' => 'Your balance is ' . $balance . ' ' . $currency . '.',
    ])->render();
} else {
    echo $blade->make('atm.not_auth', [
        'message' => 'Invalid PIN code. Try again.',
    ])->render();
}
