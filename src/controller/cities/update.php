<?php
require '../../model/City.php';
require '../../vendor/autoload.php';

$id = $_POST['id'];
$name = trim($_POST['name']) ?? null;

if (empty($name)) {
    echo "<script>alert('Failed to create a city. Name cannot be empty.'); window.location.href='/controller/cities/index.php';</script>";
    die();
}

try {
    $executionResult = City::update($id, $name);
    if ($executionResult) {
        header("Location: /controller/cities/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to update the city. Error: $errorMessage'); window.location.href='/controller/cities/index.php';</script>";
}
