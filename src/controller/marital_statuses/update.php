<?php
require '../../model/db_functions.php';
require '../../vendor/autoload.php';

$id = $_POST['id'];
$name = trim($_POST['name']) ?? null;

if (empty($name)) {
    echo "<script>alert('Failed to create a marital status. Name cannot be empty.'); window.location.href='/controller/marital_statuses/index.php';</script>";
    die();
}


$query = "UPDATE marital_status SET name = ? WHERE id = ?";

$params = [
    $name,
    $id
];

try {
    $executionResult = executeQuery($query, $params);
    if ($executionResult) {
        header("Location: /controller/marital_statuses/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to update the marital status. Error: $errorMessage'); window.location.href='/controller/marital_statuses/index.php';</script>";
}