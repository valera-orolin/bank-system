<?php
require '../../model/Account.php';
require '../../model/Currency.php';
require '../../model/DepositType.php';
require '../../model/CreditType.php';
require '../../model/Deposit.php';
require '../../model/CurrentDate.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

Deposit::clear();
Account::clear();
DepositType::clear();
CreditType::clear();
Currency::clear();

Currency::storeWithId(1, 'Белорусский рубль', 'BYN', 1.0);
Currency::storeWithId(2, 'Российский рубль', 'RUB', 0.0354);
Currency::storeWithId(3, 'Американский доллар', 'USD', 3.224);

DepositType::store('Отзывный вклад 1', 3, 1, 100, 90, 'revocable');
DepositType::store('Отзывный вклад 2', 2, 2, 100, 90, 'revocable');
DepositType::store('Безотзывный вклад 1', 3, 1, 100, 32, 'irrevocable');
DepositType::store('Безотзывный вклад 2', 0.1, 3, 100, 360, 'irrevocable');

CreditType::store('Кредит «План Б»', 16, 1, 25000, 200000, 360, 1800, 'annuity');
CreditType::store('Автокредит', 16.44, 1, 5000, 200000, 360, 3600, 'differentiated');

Account::store('0000000000001', '1010', 'active', 0, 0, 0, null, 1);
Account::store('0000000000002', '7327', 'passive', 0, 100000000000, 100000000000, null, 1);

CurrentDate::setCurrentDate('2024-02-13');

$blade = new Blade('../../view', '../../cache');
echo $blade->make('bank.index', [
    'current_date' => CurrentDate::getCurrentDate(),
])->render();
