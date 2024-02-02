<?php
require '../../model/db_functions.php';
require '../../vendor/autoload.php';

$name = trim($_POST['name']) ?? null;

if (empty($name)) {
    echo "<script>alert('Failed to create a disability. Name cannot be empty.'); window.location.href='/controller/disabilities/index.php';</script>";
    die();
}


$query = "INSERT INTO disability (name) VALUES (?)";

$params = [
    $name,
];

try {
    $executionResult = executeQuery($query, $params);
    if ($executionResult) {
        header("Location: /controller/disabilities/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to create a disability. Error: $errorMessage'); window.location.href='/controller/disabilities/index.php';</script>";
}