<?php
require '../../../model/CreditCard.php';
require '../../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$number = $_POST['number'] ?? null;
$pin = $_POST['pin'] ?? null;

$auth = CreditCard::authenticate($number, $pin);

$blade = new Blade('../../../view', '../../../cache');

if ($auth) {
    echo $blade->make('atm.payment', [
        'message' => 'Enter amount of money to put on this number.',
    ])->render();
} else {
    echo $blade->make('atm.not_auth', [
        'message' => 'Invalid PIN code. Try again.',
    ])->render();
}
