<?php
require '../../model/Client.php';
require '../../vendor/autoload.php';

$id = $_POST['id'];

try {
    $executionResult = Client::destroy($id);
    if ($executionResult) {
        header("Location: /controller/clients/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to delete the client. Error: $errorMessage'); window.location.href='/controller/clients/index.php';</script>";
}