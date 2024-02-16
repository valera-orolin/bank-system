<?php
require '../../model/Credit.php';
require '../../model/CreditType.php';
require '../../model/Currency.php';
require '../../vendor/autoload.php';
use Jenssegers\Blade\Blade;

$creditid = $_GET['creditid'] ?? null;

$period = Credit::getPeriod($creditid);
$rate = Credit::getRate($creditid);
$amount = Credit::getAmount($creditid);
$currency = Credit::getCurrency($creditid);
$payment_type = CreditType::getPaymentType(Credit::getCreditType($creditid));
$interval = 0;
$schedule = array();

if ($payment_type == 'differentiated') {

    $interest_byn = bcdiv(bcdiv(bcmul($amount, $rate * 30, 8), '360', 8), '100', 8);
    $interest_cur = bcdiv($interest_byn, Currency::getExchangeRate($currency), 8);

    for ($i = 30; $i <= $period; $i += 30) {
        $schedule[$i]['interest'] = $interest_cur;
        $schedule[$i]['current'] = 0;
    }

    $amount_byn = $amount;
    $amount_cur = bcdiv($amount_byn, Currency::getExchangeRate($currency), 8);

    $schedule[$period]['current'] = $amount_cur;
} else if ($payment_type == 'annuity') {

    for ($i = 30; $i <= $period; $i += 30) {
        $exchange_rate = Currency::getExchangeRate($currency);
        $rate_month = $rate / 100 / 12;
        $period_month = $period / 30;
        $interval_month = $i / 30;
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

        $schedule[$i]['interest'] = $interest_cur;
        $schedule[$i]['current'] = $current_cur;
    }
}

$blade = new Blade('../../view', '../../cache');
echo $blade->make('credits.payment_schedule', [
    'schedule' => $schedule,
])->render();
