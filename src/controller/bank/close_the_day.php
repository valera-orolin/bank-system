<?php
require '../../model/CurrentDate.php';
require '../../model/Account.php';
require '../../model/Deposit.php';
require '../../model/Currency.php';
require '../../model/DepositType.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$days = $_POST['days'] ? $_POST['days'] : 0;

for ($i = 0; $i < $days; $i++) {
    $deposits = Deposit::all();
    foreach ($deposits as $deposit) {
        $rate = Deposit::getRate($deposit['id']);
        $amount = Deposit::getAmount($deposit['id']);
        $currency = Deposit::getCurrency($deposit['id']);
        $interest_byn = bcdiv(bcdiv(bcmul($amount, $rate, 8), '360', 8), '100', 8);

        $interest_account = $deposit['interest_account'];
        $bank_development_fund = Account::getIdByNumber('0000000000002');
        $bank_cash_desk = Account::getIdByNumber('0000000000001');

        $interest_cur = bcdiv($interest_byn, Currency::getExchangeRate($currency), 8);
        Account::withdraw($bank_development_fund, $interest_byn);
        Account::deposit($interest_account, $interest_cur);

        $start_date = new DateTime($deposit['start_date']);
        $current_date = new DateTime(CurrentDate::getCurrentDate());
        $interval = $start_date->diff($current_date)->days + 1;
        if ($interval % 30 == 0 && $interval > 0) {
            $balance_cur = Account::getBalance($interest_account);
            Account::withdraw($interest_account, $balance_cur);
            $balance_byn = bcmul($balance_cur, Currency::getExchangeRate($currency), 8);
            Account::deposit($bank_cash_desk, $balance_byn);
            Account::withdraw($bank_cash_desk, $balance_byn);
        }

        $period = DepositType::getPeriod($deposit['deposit_type']);
        if ($interval == $period) {
            $amount_byn = $amount;
            $amount_cur = bcdiv($amount_byn, Currency::getExchangeRate($currency), 8);
            Account::withdraw($bank_development_fund, $amount_byn);
            $current_account = $deposit['current_account'];
            Account::deposit($current_account, $amount_cur);
            Account::withdraw($current_account, $amount_cur);
            Account::deposit($bank_cash_desk, $amount_byn);
            Account::withdraw($bank_cash_desk, $amount_byn);

            $balance_cur = Account::getBalance($interest_account);
            Account::withdraw($interest_account, $balance_cur);
            $balance_byn = bcmul($balance_cur, Currency::getExchangeRate($currency), 8);
            Account::deposit($bank_cash_desk, $balance_byn);
            Account::withdraw($bank_cash_desk, $balance_byn);

            Deposit::destroy($deposit['id']);
        }
    }
    CurrentDate::incrementDate();
}

$blade = new Blade('../../view', '../../cache');
echo $blade->make('bank.index', [
    'current_date' => CurrentDate::getCurrentDate(),
])->render();
