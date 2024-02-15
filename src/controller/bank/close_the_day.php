<?php
require '../../model/CurrentDate.php';
require '../../model/Account.php';
require '../../model/Deposit.php';
require '../../model/Currency.php';
require '../../model/DepositType.php';
require '../../model/Credit.php';
require '../../model/CreditType.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$days = $_POST['days'] ? $_POST['days'] : 0;

for ($i = 0; $i < $days; $i++) {

    $deposits = Deposit::all();
    foreach ($deposits as $deposit) {
        $start_date = new DateTime($deposit['start_date']);
        $current_date = new DateTime(CurrentDate::getCurrentDate());
        if ($start_date > $current_date) {
            continue;
        }

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

    $credits = Credit::all();
    foreach ($credits as $credit) {

        $start_date = new DateTime($credit['start_date']);
        $current_date = new DateTime(CurrentDate::getCurrentDate());
        if ($start_date > $current_date) {
            continue;
        }

        $interval = $start_date->diff($current_date)->days + 1;
        if ($interval % 30 != 0) {
            continue;
        }

        $period = Credit::getPeriod($credit['id']);
        $rate = Credit::getRate($credit['id']);
        $amount = Credit::getAmount($credit['id']);
        $currency = Credit::getCurrency($credit['id']);
        $interest_account = $credit['interest_account'];
        $current_account = $credit['current_account'];
        $bank_development_fund = Account::getIdByNumber('0000000000002');
        $bank_cash_desk = Account::getIdByNumber('0000000000001');

        $payment_type = CreditType::getPaymentType($credit['credit_type']);
        if ($payment_type == 'differentiated') {

            $interest_byn = bcdiv(bcdiv(bcmul($amount, $rate * 30, 8), '360', 8), '100', 8);
            $interest_cur = bcdiv($interest_byn, Currency::getExchangeRate($currency), 8);

            Account::deposit($bank_cash_desk, $interest_byn);
            Account::withdraw($bank_cash_desk, $interest_byn);
            Account::deposit($interest_account, $interest_cur);
            Account::withdraw($interest_account, $interest_cur);
            Account::deposit($bank_development_fund, $interest_byn);

            if ($interval == $period) {

                $amount_byn = $amount;
                $amount_cur = bcdiv($amount_byn, Currency::getExchangeRate($currency), 8);

                Account::deposit($bank_cash_desk, $amount_byn);
                Account::withdraw($bank_cash_desk, $amount_byn);
                Account::deposit($current_account, $amount_cur);
                Account::withdraw($current_account, $amount_cur);
                Account::deposit($bank_development_fund, $amount_byn);

                Credit::destroy($credit['id']);
            }
        } else if ($payment_type == 'annuity') {

            $exchange_rate = Currency::getExchangeRate($currency);
            $rate_month = $rate / 100 / 12;
            $period_month = $period / 30;
            $interval_month = $interval / 30;
            $amount_byn = $amount;

            bcscale(12);

            // Расчет ежемесячного аннуитетного платежа
            $annuity_payment = bcdiv(bcmul($amount_byn, bcmul($rate_month, bcpow(bcadd(1, $rate_month), $period_month))), bcsub(bcpow(bcadd(1, $rate_month), $period_month), 1));

            // Расчет остатка долга после предыдущего платежа
            $remaining_debt = bcsub(bcmul($amount_byn, bcpow(bcadd(1, $rate_month), $interval_month)), bcmul($annuity_payment, bcdiv(bcsub(bcpow(bcadd(1, $rate_month), $interval_month), 1), $rate_month)));

            // Расчет платежа по процентам
            $interest_byn = bcmul($remaining_debt, $rate_month);
            $interest_cur = bcdiv($interest_byn, $exchange_rate, 8);

            // Расчет платежа по основному долгу
            $current_byn = bcsub($annuity_payment, $interest_byn);
            $current_cur = bcdiv($current_byn, $exchange_rate, 8);

            Account::deposit($bank_cash_desk, $current_byn);
            Account::withdraw($bank_cash_desk, $current_byn);
            Account::deposit($current_account, $current_cur);
            Account::withdraw($current_account, $current_cur);
            Account::deposit($bank_development_fund, $current_byn);

            Account::deposit($bank_cash_desk, $interest_byn);
            Account::withdraw($bank_cash_desk, $interest_byn);
            Account::deposit($interest_account, $interest_cur);
            Account::withdraw($interest_account, $interest_cur);
            Account::deposit($bank_development_fund, $interest_byn);

            if ($interval == $period) {
                Credit::destroy($credit['id']);
            }
        }
    }

    CurrentDate::incrementDate();
}

$blade = new Blade('../../view', '../../cache');
echo $blade->make('bank.index', [
    'current_date' => CurrentDate::getCurrentDate(),
])->render();
