<?php
require '../../model/Credit.php';
require '../../model/Account.php';
require '../../model/Currency.php';
require '../../model/CreditType.php';
require '../../model/CurrentDate.php';
require '../../vendor/autoload.php';

$credit_type = trim($_POST['credit_type']) ?? null;
$start_date = trim($_POST['start_date']) ?? null;
$client = trim($_POST['client']) ?? null;
$amount = isset($_POST['amount']) ? trim($_POST['amount']) : null;
$period = isset($_POST['period']) ? trim($_POST['period']) : null;

$fields = ['credit_type', 'start_date', 'client', 'period'];
foreach ($fields as $field) {
    if (empty($$field)) {
        echo "<script>alert('Failed to create a credit. The field $field is empty.'); window.location.href='/controller/credits/index.php';</script>";
        die();
    }
}

$current_date = CurrentDate::getCurrentDate();
if (strtotime($start_date) < strtotime($current_date)) {
    echo "<script>alert('Failed to create a credit. Start date cannot be earlier than the current date.'); window.location.href='/controller/credits/index.php';</script>";
    die();
}

if ($amount < 0) {
    echo "<script>alert('Failed to create a credit. Amount must be a positive number.'); window.location.href='/controller/credits/index.php';</script>";
    die();
}

if ($period % 30 != 0) {
    echo "<script>alert('Failed to create a credit. Period must be a multiple of 30.'); window.location.href='/controller/credits/index.php';</script>";
    die();
}

try {
    $currency = CreditType::getCurrency($credit_type);
    $minAmount = CreditType::getMinAmount($credit_type);
    $maxAmount = CreditType::getMaxAmount($credit_type);
    $minPeriod = CreditType::getMinPeriod($credit_type);
    $maxPeriod = CreditType::getMaxPeriod($credit_type);

    if ($amount < $minAmount || $amount > $maxAmount) {
        echo "<script>alert('Failed to create a credit. Amount must be between {$minAmount} and {$maxAmount}'); window.location.href='/controller/credits/index.php';</script>";
        die();
    }

    if ($period < $minPeriod || $period > $maxPeriod) {
        echo "<script>alert('Failed to create a credit. Period must be between {$minPeriod} and {$maxPeriod}'); window.location.href='/controller/credits/index.php';</script>";
        die();
    }

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
    Account::withdraw($current_account, $amount_cur);
    Account::deposit($bank_cash_desk, $amount_byn);
    Account::withdraw($bank_cash_desk, $amount_byn);

    $executionResult = Credit::store($credit_type, $start_date, $period, $client, $current_account, $interest_account, $amount);

    if ($executionResult) {
        header("Location: /controller/credits/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to create a credit. Error: $errorMessage'); window.location.href='/controller/credits/index.php';</script>";
}
