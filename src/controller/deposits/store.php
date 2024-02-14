<?php
require '../../model/Deposit.php';
require '../../model/Account.php';
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
    // Get currency, revocation, and amount range from deposit_type
    $currency = DepositType::getCurrency($deposit_type);
    $revocation = DepositType::getRevocation($deposit_type);
    $amountRange = DepositType::getAmountRange($deposit_type);

    if ($amount < $amountRange['min_amount'] || $amount > $amountRange['max_amount']) {
        echo "<script>alert('Failed to create a deposit. Amount must be between {$amountRange['min_amount']} and {$amountRange['max_amount']}'); window.location.href='/controller/deposits/index.php';</script>";
        die();
    }

    $current_account = Account::createCurrentAccount($client, $currency, $revocation);
    $interest_account = Account::createInterestAccount($client, $currency, $revocation);
    $bank_cash_desk = Account::getIdByNumber('0000000000001');
    $bank_development_fund = Account::getIdByNumber('0000000000002');

    Account::deposit($bank_cash_desk, $amount);
    Account::transfer($bank_cash_desk, $current_account, $amount);
    Account::transfer($current_account, $bank_development_fund, $amount);

    // Create deposit
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
