<?php
require '../../model/Credit.php';
require '../../model/CurrentDate.php';
require '../../vendor/autoload.php';

$id = $_POST['id'];
$credit_type = trim($_POST['credit_type']) ?? null;
$start_date = trim($_POST['start_date']) ?? null;
$client = trim($_POST['client']) != '' ? trim($_POST['client']) : null;
$amount = isset($_POST['amount']) ? trim($_POST['amount']) : null;
$current_account = trim($_POST['current_account']) ?? null;
$interest_account = trim($_POST['interest_account']) ?? null;
$period = isset($_POST['period']) ? trim($_POST['period']) : null;

$fields = ['credit_type', 'start_date', 'client', 'current_account', 'interest_account'];
foreach ($fields as $field) {
    if (empty($$field)) {
        echo "<script>alert('Failed to update a credit. The field $field is empty.'); window.location.href='/controller/credits/index.php';</script>";
        die();
    }
}

$current_date = CurrentDate::getCurrentDate();
if (strtotime($start_date) < strtotime($current_date)) {
    echo "<script>alert('Failed to update a credit. Start date cannot be earlier than the current date.'); window.location.href='/controller/credits/index.php';</script>";
    die();
}

if ($amount < 0) {
    echo "<script>alert('Failed to update a credit. Amount must be a positive number.'); window.location.href='/controller/credits/index.php';</script>";
    die();
}

if ($period % 30 != 0) {
    echo "<script>alert('Failed to create a credit. Period must be a multiple of 30.'); window.location.href='/controller/credits/index.php';</script>";
    die();
}

try {
    $executionResult = Credit::update($id, $credit_type, $start_date, $period, $client, $current_account, $interest_account, $amount);
    if ($executionResult) {
        header("Location: /controller/credits/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to update the credit. Error: $errorMessage'); window.location.href='/controller/credits/index.php';</script>";
}
