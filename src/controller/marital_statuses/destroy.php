<?php
require '../../model/MaritalStatus.php';
require '../../vendor/autoload.php';

$id = $_POST['id'];

try {
    $executionResult = MaritalStatus::destroy($id);
    if ($executionResult) {
        header("Location: /controller/marital_statuses/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to delete the marital statuses. Error: $errorMessage'); window.location.href='/controller/marital_statuses/index.php';</script>";
}