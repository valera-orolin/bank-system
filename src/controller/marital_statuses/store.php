<?php
require '../../model/MaritalStatus.php';
require '../../vendor/autoload.php';

$name = trim($_POST['name']) ?? null;

if (empty($name)) {
    echo "<script>alert('Failed to create a marital status. Name cannot be empty.'); window.location.href='/controller/marital_statuses/index.php';</script>";
    die();
}

try {
    $executionResult = MaritalStatus::store($name);
    if ($executionResult) {
        header("Location: /controller/marital_statuses/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to create a city. Error: $errorMessage'); window.location.href='/controller/marital_statuses/index.php';</script>";
}