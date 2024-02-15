<?php
require '../../model/CreditType.php';
require '../../vendor/autoload.php';

$name = trim($_POST['name']) ?? null;
$rate = trim($_POST['rate']) ?? null;
$currency = trim($_POST['currency']) ?? null;
$min_amount = trim($_POST['min_amount']) ?? null;
$max_amount = trim($_POST['max_amount']) ?? null;
$min_period = trim($_POST['min_period']) ?? null;
$max_period = trim($_POST['max_period']) ?? null;
$payment_type = trim($_POST['payment_type']) ?? null;

if (empty($name) || empty($rate) || empty($currency) || empty($min_amount) || empty($max_amount) || empty($min_period) || empty($max_period) || empty($payment_type)) {
    echo "<script>alert('Failed to create a credit type. None of the fields can be empty.'); window.location.href='/controller/credit_types/index.php';</script>";
    die();
}

if ($min_amount <= 0 || $max_amount <= 0) {
    echo "<script>alert('Failed to create a credit type. Minimum and Maximum amounts must be positive numbers.'); window.location.href='/controller/credit_types/index.php';</script>";
    die();
}

if ($min_period <= 0 || $max_period <= 0) {
    echo "<script>alert('Failed to create a credit type. Minimum and Maximum periods must be positive numbers.'); window.location.href='/controller/credit_types/index.php';</script>";
    die();
}

if ($min_amount > $max_amount) {
    echo "<script>alert('Failed to create a credit type. Minimum amount can not be greater than maximum'); window.location.href='/controller/credit_types/index.php';</script>";
    die();
}

if ($min_period > $max_period) {
    echo "<script>alert('Failed to create a credit type. Minimum period can not be greater than maximum'); window.location.href='/controller/credit_types/index.php';</script>";
    die();
}

try {
    $executionResult = CreditType::store($name, $rate, $currency, $min_amount, $max_amount, $min_period, $max_period, $payment_type);
    if ($executionResult) {
        header("Location: /controller/credit_types/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to create a credit type. Error: $errorMessage'); window.location.href='/controller/credit_types/index.php';</script>";
}
