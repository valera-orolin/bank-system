<?php
require '../../model/Disability.php';
require '../../vendor/autoload.php';

$id = $_POST['id'];

try {
    $executionResult = Disability::destroy($id);
    if ($executionResult) {
        header("Location: /controller/disabilities/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to delete the disability. Error: $errorMessage'); window.location.href='/controller/disabilities/index.php';</script>";
}