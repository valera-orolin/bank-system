<?php
require '../../model/Deposit.php';
require '../../vendor/autoload.php';

$id = $_POST['id'];
$deposit_type = trim($_POST['deposit_type']) ?? null;
$start_date = trim($_POST['start_date']) ?? null;
$client = trim($_POST['client']) != '' ? trim($_POST['client']) : null;
$amount = isset($_POST['amount']) ? trim($_POST['amount']) : null;
$current_account = trim($_POST['current_account']) ?? null;
$interest_account = trim($_POST['interest_account']) ?? null;

$fields = ['deposit_type', 'start_date', 'client', 'current_account', 'interest_account'];
foreach ($fields as $field) {
    if (empty($$field)) {
        echo "<script>alert('Failed to update a deposit. The field $field is empty.'); window.location.href='/controller/deposits/index.php';</script>";
        die();
    }
}

if ($amount < 0) {
    echo "<script>alert('Failed to update a deposit. Amount must be a positive number.'); window.location.href='/controller/deposits/index.php';</script>";
    die();
}

try {
    $executionResult = Deposit::update($id, $deposit_type, $start_date, $client, $current_account, $interest_account, $amount);
    if ($executionResult) {
        header("Location: /controller/deposits/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to update the deposit. Error: $errorMessage'); window.location.href='/controller/deposits/index.php';</script>";
}
