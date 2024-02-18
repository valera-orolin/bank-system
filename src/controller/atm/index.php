<?php
require '../../model/CreditCard.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$number = $_POST['number'] ?? null;
$pin = $_POST['pin'] ?? null;

if ($number !== null && !preg_match('/^\d{16}$/', $number)) {
    echo "<script>alert('The card number must consist of 16 digits.'); window.location.href='/controller/atm/index.php';</script>";
    die();
}

if ($pin !== null && !preg_match('/^\d{4}$/', $pin)) {
    echo "<script>alert('The PIN code must consist of 4 digits'); window.location.href='/controller/atm/index.php';</script>";
    die();
}

$auth = CreditCard::authenticate($number, $pin);

$blade = new Blade('../../view', '../../cache');

if ($auth) {
    echo $blade->make('atm.auth', [
        'message' => 'You have successfully logged in!',
    ])->render();
} else {
    echo $blade->make('atm.not_auth', [
        'message' => 'Invalid PIN code. Try again.',
    ])->render();
}
