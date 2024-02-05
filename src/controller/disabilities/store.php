<?php
require '../../model/Disability.php';
require '../../vendor/autoload.php';

$name = trim($_POST['name']) ?? null;

if (empty($name)) {
    echo "<script>alert('Failed to create a disability. Name cannot be empty.'); window.location.href='/controller/disabilities/index.php';</script>";
    die();
}

try {
    $executionResult = Disability::store($name);
    if ($executionResult) {
        header("Location: /controller/disabilities/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to create a disability. Error: $errorMessage'); window.location.href='/controller/disabilities/index.php';</script>";
}
