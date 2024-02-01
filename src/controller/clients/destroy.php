<?php
require '../../model/db_functions.php';
require '../../vendor/autoload.php';

$id = $_POST['id'];

$query = "DELETE FROM client WHERE id = ?";
$params = [$id];

try {
    $executionResult = executeQuery($query, $params);
    if ($executionResult) {
        header("Location: /controller/clients/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to delete the client. Error: $errorMessage'); window.location.href='/controller/clients/index.php';</script>";
}