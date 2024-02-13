<?php
require '../../model/Currency.php';
require '../../vendor/autoload.php';

$name = trim($_POST['name']) ?? null;
$symbol = trim($_POST['symbol']) ?? null;
$exchange_rate = trim($_POST['exchange_rate']) ?? null;

if (empty($name) || empty($symbol) || empty($exchange_rate)) {
    echo "<script>alert('Failed to create a currency. Name, symbol and exchange rate cannot be empty.'); window.location.href='/controller/currencies/index.php';</script>";
    die();
}

try {
    $executionResult = Currency::store($name, $symbol, $exchange_rate);
    if ($executionResult) {
        header("Location: /controller/currencies/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to create a currency. Error: $errorMessage'); window.location.href='/controller/currencies/index.php';</script>";
}
