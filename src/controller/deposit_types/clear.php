<?php
require '../../model/DepositType.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

DepositType::clear();
DepositType::store('Отзывный вклад', 3, 1, 100, 5000, 90, 'revocable');
DepositType::store('Отзывный вклад', 2, 2, 100, 5000, 90, 'revocable');
DepositType::store('Безотзывный вклад', 3, 1, 100, 5000, 32, 'irrevocable');
DepositType::store('Безотзывный вклад', 0.1, 3, 100, 5000, 360, 'irrevocable');

$blade = new Blade('../../view', '../../cache');
echo $blade->make('bank.index')->render();
