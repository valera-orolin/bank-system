<?php
require '../../model/City.php';
require '../../vendor/autoload.php';

$id = $_POST['id'];

try {
    $executionResult = City::destroy($id);
    if ($executionResult) {
        header("Location: /controller/cities/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to delete the city. Error: $errorMessage'); window.location.href='/controller/cities/index.php';</script>";
}
