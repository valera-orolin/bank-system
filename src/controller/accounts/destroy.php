<?php
require '../../model/Account.php';
require '../../vendor/autoload.php';

$id = $_POST['id'];

try {
    $executionResult = Account::destroy($id);
    if ($executionResult) {
        header("Location: /controller/accounts/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to delete the account. Error: $errorMessage'); window.location.href='/controller/accounts/index.php';</script>";
}
