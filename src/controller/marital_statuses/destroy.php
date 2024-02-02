<?php
require '../../model/db_functions.php';
require '../../vendor/autoload.php';

$id = $_POST['id'];

$query = "DELETE FROM marital_status WHERE id = ?";
$params = [$id];

try {
    $executionResult = executeQuery($query, $params);
    if ($executionResult) {
        header("Location: /controller/marital_statuses/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to delete the marital statuses. Error: $errorMessage'); window.location.href='/controller/marital_statuses/index.php';</script>";
}