<?php
require '../../model/DepositType.php';
require '../../vendor/autoload.php';

$id = $_POST['id'];

try {
    $executionResult = DepositType::destroy($id);
    if ($executionResult) {
        header("Location: /controller/deposit_types/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to delete the deposit type. Error: $errorMessage'); window.location.href='/controller/deposit_types/index.php';</script>";
}
