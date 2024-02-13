<?php
require '../../model/DepositType.php';
require '../../vendor/autoload.php';

$name = trim($_POST['name']) ?? null;
$rate = trim($_POST['rate']) ?? null;
$currency = trim($_POST['currency']) ?? null;
$min_amount = trim($_POST['min_amount']) ?? null;
$max_amount = trim($_POST['max_amount']) ?? null;
$period = trim($_POST['period']) ?? null;
$revocation = trim($_POST['revocation']) ?? null;

if (empty($name) || empty($rate) || empty($currency) || empty($min_amount) || empty($max_amount) || empty($period) || empty($revocation)) {
    echo "<script>alert('Failed to create a deposit type. None of the fields can be empty.'); window.location.href='/controller/deposit_types/index.php';</script>";
    die();
}

if ($min_amount < 0 || $max_amount < 0) {
    echo "<script>alert('Failed to create a deposit type. Minimal and maximal amounts must be positive numbers.'); window.location.href='/controller/deposit_types/index.php';</script>";
    die();
}

if ($min_amount >= $max_amount) {
    echo "<script>alert('Failed to create a deposit type. Maximal amount must be greater than minimal.'); window.location.href='/controller/deposit_types/index.php';</script>";
    die();
}

try {
    $executionResult = DepositType::store($name, $rate, $currency, $min_amount, $max_amount, $period, $revocation);
    if ($executionResult) {
        header("Location: /controller/deposit_types/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to create a deposit type. Error: $errorMessage'); window.location.href='/controller/deposit_types/index.php';</script>";
}
