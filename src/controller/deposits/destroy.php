<?php
require '../../model/Deposit.php';
require '../../vendor/autoload.php';

$id = $_POST['id'];

try {
    $executionResult = Deposit::destroy($id);
    if ($executionResult) {
        header("Location: /controller/deposits/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to delete the deposit. Error: $errorMessage'); window.location.href='/controller/deposits/index.php';</script>";
}
