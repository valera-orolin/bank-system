<?php
require '../../model/CreditType.php';
require '../../vendor/autoload.php';

$id = $_POST['id'];

try {
    $executionResult = CreditType::destroy($id);
    if ($executionResult) {
        header("Location: /controller/credit_types/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to delete the credit type. Error: $errorMessage'); window.location.href='/controller/credit_types/index.php';</script>";
}
