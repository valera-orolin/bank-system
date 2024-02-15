<?php
require '../../model/Credit.php';
require '../../vendor/autoload.php';

$id = $_POST['id'];

try {
    $executionResult = Credit::destroy($id);
    if ($executionResult) {
        header("Location: /controller/credits/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to delete the credit. Error: $errorMessage'); window.location.href='/controller/credits/index.php';</script>";
}
