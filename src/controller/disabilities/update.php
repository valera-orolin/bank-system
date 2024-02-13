<?php
require '../../model/Disability.php';
require '../../vendor/autoload.php';

$id = $_POST['id'];
$name = trim($_POST['name']) ?? null;

if (empty($name)) {
    echo "<script>alert('Failed to update a disability. Name cannot be empty.'); window.location.href='/controller/disabilities/index.php';</script>";
    die();
}

try {
    $executionResult = Disability::update($id, $name);
    if ($executionResult) {
        header("Location: /controller/disabilities/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to update the disability. Error: $errorMessage'); window.location.href='/controller/disabilities/index.php';</script>";
}
