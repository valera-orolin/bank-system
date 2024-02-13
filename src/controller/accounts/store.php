<?php
require '../../model/Account.php';
require '../../vendor/autoload.php';

$number = trim($_POST['number']) ?? null;
$code = trim($_POST['code']) ?? null;
$activity = trim($_POST['activity']) ?? null;
$debit = isset($_POST['debit']) ? trim($_POST['debit']) : null;
$credit = isset($_POST['credit']) ? trim($_POST['credit']) : null;
$balance = isset($_POST['balance']) ? trim($_POST['balance']) : null;
$client = trim($_POST['client']) ?? null;
$currency = trim($_POST['currency']) ?? null;

$fields = ['number', 'code', 'activity', 'currency'];
foreach ($fields as $field) {
    if (empty($$field)) {
        echo "<script>alert('Failed to create an account. The field $field is empty.'); window.location.href='/controller/accounts/index.php';</script>";
        die();
    }
}

if ($debit < 0 || $credit < 0 || $balance < 0) {
    echo "<script>alert('Failed to create an account. Debit, credit and balance must be positive numbers.'); window.location.href='/controller/accounts/index.php';</script>";
    die();
}

try {
    $executionResult = Account::store($number, $code, $activity, $debit, $credit, $balance, $client, $currency);
    if ($executionResult) {
        header("Location: /controller/accounts/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to create an account. Error: $errorMessage'); window.location.href='/controller/accounts/index.php';</script>";
}
