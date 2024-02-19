<?php
require '../../../model/CreditCard.php';
require '../../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$number = $_POST['number'] ?? null;
$pin = $_POST['pin'] ?? null;

$auth = CreditCard::authenticate($number, $pin);

$blade = new Blade('../../../view', '../../../cache');

if ($auth) {
    echo $blade->make('atm.cash_withdrawal', [
        'message' => 'Enter amount of cash.',
    ])->render();
} else {
    echo $blade->make('atm.not_auth', [
        'message' => 'Invalid PIN code. Try again.',
    ])->render();
}
