<?php
require '../../model/Currency.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

Currency::clear();
Currency::store('Белорусский рубль', 'BYN', 1.0);
Currency::store('Российский рубль', 'RUB', 0.0354);
Currency::store('Американский доллар', 'USD', 3.224);

$blade = new Blade('../../view', '../../cache');
echo $blade->make('bank.index')->render();
