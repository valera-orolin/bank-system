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
    // Get currency from deposit_type
    $currency = DepositType::getCurrency($deposit_type);

    // Create current_account
    $current_account_number = substr(str_shuffle(str_repeat($x='0123456789', ceil(13/strlen($x)) )),1,13);
    $current_account_code = "3014";
    $current_account_activity = "passive";
    $current_account_debit = 0;
    $current_account_credit = 0;
    $current_account_balance = 0;

    $current_account = Account::store($current_account_number, $current_account_code, $current_account_activity, $current_account_debit, $current_account_credit, $current_account_balance, $client, $currency);

    // Create interest_account
    $interest_account_number = substr(str_shuffle(str_repeat($x='0123456789', ceil(13/strlen($x)) )),1,13);
    $interest_account_code = "3015";
    $interest_account_activity = "passive";
    $interest_account_debit = 0;
    $interest_account_credit = 0;
    $interest_account_balance = 0;

    $interest_account = Account::store($interest_account_number, $interest_account_code, $interest_account_activity, $interest_account_debit, $interest_account_credit, $interest_account_balance, $client, $currency);

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
