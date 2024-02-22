<?php
require '../../../model/CreditCard.php';
require '../../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$number = $_POST['number'] ?? null;
$pin = $_POST['pin'] ?? null;

$blade = new Blade('../../../view', '../../../cache');

try {
    $auth = CreditCard::authenticate($number, $pin);
} catch (Exception $e) {
    echo $blade->make('atm.not_auth', [
        'message' => $e->getMessage(),
    ])->render();
    die();
}

if ($auth) {
    echo $blade->make('atm.cash_withdrawal', [
        'message' => 'Enter amount of cash.',
    ])->render();
} else {
    echo $blade->make('atm.not_auth', [
        'message' => 'Invalid PIN code. Try again.',
    ])->render();
}
