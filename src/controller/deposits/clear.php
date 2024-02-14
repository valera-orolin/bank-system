<?php
require '../../model/Deposit.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

Deposit::clear();

$blade = new Blade('../../view', '../../cache');
echo $blade->make('bank.index')->render();
