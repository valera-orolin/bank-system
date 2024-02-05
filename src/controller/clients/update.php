<?php
require '../../model/Client.php';
require '../../vendor/autoload.php';

$id = $_POST['id'];
$surname = trim($_POST['surname']) ?? null;
$firstname = trim($_POST['firstname']) ?? null;
$patronymic = trim($_POST['patronymic']) ?? null;
$birth_date = trim($_POST['birth_date']) ?? null;
$gender = trim($_POST['gender']) ?? null;
$passport_series = trim($_POST['passport_series']) ?? null;
$passport_number = trim($_POST['passport_number']) ?? null;
$issued_by = trim($_POST['issued_by']) ?? null;
$issue_date = trim($_POST['issue_date']) ?? null;
$id_number = trim($_POST['id_number']) ?? null;
$place_of_birth = trim($_POST['place_of_birth']) ?? null;
$city_of_residence = trim($_POST['city_of_residence']) ?? null;
$residence_address = trim($_POST['residence_address']) ?? null;
$home_phone = trim($_POST['home_phone']) ?? null; //
$mobile_phone = trim($_POST['mobile_phone']) ?? null; //
$place_of_work = trim($_POST['place_of_work']) ?? null; //
$position_at_work = trim($_POST['position_at_work']) ?? null; //
$email = trim($_POST['email']) ?? null; //
$registration_city = trim($_POST['registration_city']) ?? null;
$marital_status = trim($_POST['marital_status']) ?? null;
$citizenship = trim($_POST['citizenship']) ?? null;
$disability = trim($_POST['disability']) ?? null;
$pensioner = isset($_POST['pensioner']) ? 1 : 0;
$monthly_income = isset($_POST['monthly_income']) && $_POST['monthly_income'] !== '' ? trim($_POST['monthly_income']) : null; //

if (empty($surname)) {
    echo "<script>alert('Failed to update the client. Surname cannot be empty.'); window.location.href='/controller/clients/index.php';</script>";
    die();
}

if (empty($firstname)) {
    echo "<script>alert('Failed to update the client. Firstname cannot be empty.'); window.location.href='/controller/clients/index.php';</script>";
    die();
}

if (empty($patronymic)) {
    echo "<script>alert('Failed to update the client. Patronymic cannot be empty.'); window.location.href='/controller/clients/index.php';</script>";
    die();
}

if (empty($birth_date)) {
    echo "<script>alert('Failed to update the client. Birth date cannot be empty.'); window.location.href='/controller/clients/index.php';</script>";
    die();
}

if (empty($gender)) {
    echo "<script>alert('Failed to update the client. Gender cannot be empty.'); window.location.href='/controller/clients/index.php';</script>";
    die();
}

if (empty($passport_series)) {
    echo "<script>alert('Failed to update the client. Passport series cannot be empty.'); window.location.href='/controller/clients/index.php';</script>";
    die();
}

if (empty($passport_number)) {
    echo "<script>alert('Failed to update the client. Passport number cannot be empty.'); window.location.href='/controller/clients/index.php';</script>";
    die();
}

if (empty($issued_by)) {
    echo "<script>alert('Failed to update the client. Issued by cannot be empty.'); window.location.href='/controller/clients/index.php';</script>";
    die();
}

if (empty($issue_date)) {
    echo "<script>alert('Failed to update the client. Issue date cannot be empty.'); window.location.href='/controller/clients/index.php';</script>";
    die();
}

if (empty($id_number)) {
    echo "<script>alert('Failed to update the client. Id number cannot be empty.'); window.location.href='/controller/clients/index.php';</script>";
    die();
}

if (empty($place_of_birth)) {
    echo "<script>alert('Failed to update the client. Place of birth cannot be empty.'); window.location.href='/controller/clients/index.php';</script>";
    die();
}

if (empty($city_of_residence)) {
    echo "<script>alert('Failed to update the client. City of residence cannot be empty.'); window.location.href='/controller/clients/index.php';</script>";
    die();
}

if (empty($residence_address)) {
    echo "<script>alert('Failed to update the client. Residence address cannot be empty.'); window.location.href='/controller/clients/index.php';</script>";
    die();
}

if (empty($registration_city)) {
    echo "<script>alert('Failed to update the client. Registration city cannot be empty.'); window.location.href='/controller/clients/index.php';</script>";
    die();
}

if (empty($marital_status)) {
    echo "<script>alert('Failed to update the client. Marital status cannot be empty.'); window.location.href='/controller/clients/index.php';</script>";
    die();
}

if (empty($citizenship)) {
    echo "<script>alert('Failed to update the client. Citizenship cannot be empty.'); window.location.href='/controller/clients/index.php';</script>";
    die();
}

if (empty($disability)) {
    echo "<script>alert('Failed to update the client. Disability cannot be empty.'); window.location.href='/controller/clients/index.php';</script>";
    die();
}

$same_name = Client::findByNameExcludeId($surname, $firstname, $patronymic, $id);
if ($same_name) {
    echo "<script>alert('Failed to update the client. Client with such name already exists.'); window.location.href='/controller/clients/index.php';</script>";
    die();
}

$same_passport = Client::findByPassportExcludeId($passport_series, $passport_number, $id);
if ($same_passport) {
    echo "<script>alert('Failed to update the client. Client with such passport already exists.'); window.location.href='/controller/clients/index.php';</script>";
    die();
}

$same_id_number = Client::findByIdNumberExcludeId($id_number, $id);
if ($same_id_number) {
    echo "<script>alert('Failed to update the client. Client with such id number already exists.'); window.location.href='/controller/clients/index.php';</script>";
    die();
}

if (preg_match('/\d/', $surname) || preg_match('/\d/', $firstname) || preg_match('/\d/', $patronymic)) {
    echo "<script>alert('Failed to update the client. No numbers are allowed in the name.'); window.location.href='/controller/clients/index.php';</script>";
    die();
}

list($year, $month, $day) = explode('-', $birth_date);
if (!checkdate($month, $day, $year)) {
    echo "<script>alert('Failed to update the client. Birth date is not valid.'); window.location.href='/controller/clients/index.php';</script>";
    die();
}

list($year, $month, $day) = explode('-', $issue_date);
if (!checkdate($month, $day, $year)) {
    echo "<script>alert('Failed to update the client. Issue date is not valid.'); window.location.href='/controller/clients/index.php';</script>";
    die();
}

if (!preg_match('/^[0-9]{7}$/', $passport_number)) {
    echo "<script>alert('Failed to update the client. Passport number is not valid.'); window.location.href='/controller/clients/index.php';</script>";
    die();
}

$pattern = '/^[0-9]{7}[ABCKEMH]{1}[0-9]{3}(PB|BA|BI)[0-9]{1}$/';
if (!preg_match($pattern, $id_number)) {
    echo "<script>alert('Failed to update the client. Id number is not valid.'); window.location.href='/controller/clients/index.php';</script>";
    die();
}

if (!empty($home_phone) && !preg_match('/^\d{6,9}$/', $home_phone)) {
    echo "<script>alert('Failed to update the client. Home phone is not valid.'); window.location.href='/controller/clients/index.php';</script>";
    die();
}

if (!empty($mobile_phone) && !preg_match('/^\d{6,9}$/', $mobile_phone)) {
    echo "<script>alert('Failed to update the client. Mobile phone is not valid.'); window.location.href='/controller/clients/index.php';</script>";
    die();
}

$params = [
    $surname,
    $firstname,
    $patronymic,
    $birth_date,
    $gender,
    $passport_series,
    $passport_number,
    $issued_by,
    $issue_date,
    $id_number,
    $place_of_birth,
    $city_of_residence,
    $residence_address,
    $home_phone ?? null,
    $mobile_phone ?? null,
    $place_of_work ?? null,
    $position_at_work ?? null,
    $email ?? null,
    $registration_city,
    $marital_status,
    $citizenship,
    $disability,
    $pensioner,
    $monthly_income ?? null
];

try {
    $executionResult = Client::update($params, $id);
    if ($executionResult) {
        header("Location: /controller/clients/index.php");
    } else {
        throw new Exception(mysqli_error($connect));
    }
} catch (Exception $e) {
    $errorMessage = str_replace("'", "\'", $e->getMessage());
    echo "<script>alert('Failed to update the client. Error: $errorMessage'); window.location.href='/controller/clients/index.php';</script>";
}