<?php
require '../../model/Account.php';
require '../../model/Currency.php';
require '../../model/DepositType.php';
require '../../model/CreditType.php';
require '../../model/Deposit.php';
require '../../model/Credit.php';
require '../../model/CurrentDate.php';
require '../../model/CreditCard.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

Deposit::clear();
Credit::clear();
CreditCard::clear();
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

CreditType::storeWithId(1, 'Кредит «План Б»', 16, 3, 5000, 200000, 90, 3600, 'annuity');
CreditType::storeWithId(2, 'Автокредит', 16, 3, 5000, 200000, 90, 3600, 'differentiated');

Account::store('0000000000001', '1010', 'active', 0, 0, 0, null, 1);
Account::store('0000000000002', '7327', 'passive', 0, 100000000000, 100000000000, null, 1);
Account::store('0000000000003', '5050', 'active', 0, 0, 0, null, 1);
Account::store('0000000000004', '5050', 'active', 0, 0, 0, null, 1);
Account::store('0000000000005', '5050', 'active', 0, 0, 0, null, 1);

CurrentDate::setCurrentDate('2024-02-22');


$credit_type = 1;
$start_date = CurrentDate::getCurrentDate();
$client = 1;
$amount = 10000;
$period = 90;

try {
    $currency = CreditType::getCurrency($credit_type);

    $code = '2400';
    $current_account = Account::createAccount($client, $currency, $code, 'active');
    
    $code = '2470';
    $interest_account = Account::createAccount($client, $currency, $code, 'active');

    $bank_cash_desk = Account::getIdByNumber('0000000000001');
    $bank_development_fund = Account::getIdByNumber('0000000000002');

    $amount_byn = $amount;
    $amount_cur = bcdiv($amount_byn, Currency::getExchangeRate($currency), 8);

    Account::withdraw($bank_development_fund, $amount_byn);
    Account::deposit($current_account, $amount_cur);

    $executionResult = Credit::store($credit_type, $start_date, $period, $client, $current_account, $interest_account, $amount);

    CreditCard::store('1234567890123456', '1234', $current_account);

    if (!$executionResult) {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to create a credit. Error: $errorMessage'); window.location.href='/controller/atm/index.php';</script>";
}


$blade = new Blade('../../view', '../../cache');
echo $blade->make('atm.not_auth', [
    'message' => 'Invalid PIN code. Try again.',
])->render();
