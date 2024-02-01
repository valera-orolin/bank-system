<?php
require '../../model/db_functions.php';
require '../../vendor/autoload.php';

$name = trim($_POST['name']) ?? null;

if (empty($name)) {
    echo "<script>alert('Failed to create a city. Name cannot be empty.'); window.location.href='/controller/cities/index.php';</script>";
    die();
}


$query = "INSERT INTO city (name) VALUES (?)";

$params = [
    $name,
];

try {
    $executionResult = executeQuery($query, $params);
    if ($executionResult) {
        header("Location: /controller/cities/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to create a city. Error: $errorMessage'); window.location.href='/controller/cities/index.php';</script>";
}