<?php
require '../../model/Country.php';
require '../../vendor/autoload.php';

$id = $_POST['id'];

try {
    $executionResult = Country::destroy($id);
    if ($executionResult) {
        header("Location: /controller/countries/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to delete the country. Error: $errorMessage'); window.location.href='/controller/countries/index.php';</script>";
}