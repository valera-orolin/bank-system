<?php
require '../../model/Country.php';
require '../../vendor/autoload.php';

$name = trim($_POST['name']) ?? null;

if (empty($name)) {
    echo "<script>alert('Failed to create a country. Name cannot be empty.'); window.location.href='/controller/countries/index.php';</script>";
    die();
}

try {
    $executionResult = Country::store($name);
    if ($executionResult) {
        header("Location: /controller/countries/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to create a country. Error: $errorMessage'); window.location.href='/controller/countries/index.php';</script>";
}