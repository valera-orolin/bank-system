<?php
require '../../model/Deposit.php';
require '../../model/Account.php';
require '../../model/Currency.php';
require '../../model/DepositType.php';
require '../../vendor/autoload.php';

$deposit_type = trim($_POST['deposit_type']) ?? null;
$start_date = trim($_POST['start_date']) ?? null;
$client = trim($_POST['client']) ?? null;
$amount = isset($_POST['amount']) ? trim($_POST['amount']) : null;

$fields = ['deposit_type', 'start_date', 'client'];
foreach ($fields as $field) {
    if (empty($$field)) {
        echo "<script>alert('Failed to create a deposit. The field $field is empty.'); window.location.href='/controller/deposits/index.php';</script>";
        die();
    }
}

if ($amount < 0) {
    echo "<script>alert('Failed to create a deposit. Amount must be a positive number.'); window.location.href='/controller/deposits/index.php';</script>";
    die();
}

try {
    $currency = DepositType::getCurrency($deposit_type);
    $revocation = DepositType::getRevocation($deposit_type);
    $minAmount = DepositType::getMinAmount($deposit_type);

    if ($amount < $minAmount) {
        echo "<script>alert('Failed to create a deposit. Amount must be more than {$minAmount}'); window.location.href='/controller/deposits/index.php';</script>";
        die();
    }

    $current_account = Account::createCurrentAccount($client, $currency, $revocation);
    $interest_account = Account::createInterestAccount($client, $currency, $revocation);
    $bank_cash_desk = Account::getIdByNumber('0000000000001');
    $bank_development_fund = Account::getIdByNumber('0000000000002');

    $exchangeRate = Currency::getExchangeRate($currency);
    $convertedAmount = bcdiv($amount, $exchangeRate, 8);

    Account::deposit($bank_cash_desk, $amount);
    Account::withdraw($bank_cash_desk, $amount);
    Account::deposit($current_account, $convertedAmount);
    Account::withdraw($current_account, $convertedAmount);
    Account::deposit($bank_development_fund, $amount);

    $executionResult = Deposit::store($deposit_type, $start_date, $client, $current_account, $interest_account, $amount);
    if ($executionResult) {
        header("Location: /controller/deposits/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to create a deposit. Error: $errorMessage'); window.location.href='/controller/deposits/index.php';</script>";
}
