<?php
require '../../model/Account.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$number = $_POST['number'] ?? null;
$pin = $_POST['pin'] ?? null;

$blade = new Blade('../../view', '../../cache');
echo $blade->make('atm.index', [
])->render();
