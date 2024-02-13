<?php
require '../../model/Currency.php';
require '../../vendor/autoload.php';

$id = $_POST['id'];

try {
    $executionResult = Currency::destroy($id);
    if ($executionResult) {
        header("Location: /controller/currencies/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to delete the currency. Error: $errorMessage'); window.location.href='/controller/currencies/index.php';</script>";
}
