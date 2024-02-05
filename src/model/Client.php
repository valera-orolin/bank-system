<?php
require 'db_functions.php';

class Client {
    public static function all() {
        $query = "SELECT * FROM client ORDER BY surname";
        return executeQuery($query);
    }

    public static function getCityName($id) {
        $query = "SELECT name FROM city WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['name'];
    }

    public static function getMaritalStatus($id) {
        $query = "SELECT name FROM marital_status WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['name'];
    }

    public static function getCountryName($id) {
        $query = "SELECT name FROM country WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['name'];
    }

    public static function getDisability($id) {
        $query = "SELECT name FROM disability WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['name'];
    }

    public static function destroy($id) {
        $query = "DELETE FROM client WHERE id = ?";
        return executeQuery($query, [$id]);
    }

    public static function findByName($surname, $firstname, $patronymic) {
        $query = "SELECT * FROM client WHERE surname = ? AND firstname = ? AND patronymic = ?";
        return executeQuery($query, [$surname, $firstname, $patronymic]);
    }

    public static function findByPassport($passport_series, $passport_number) {
        $query = "SELECT * FROM client WHERE passport_series = ? AND passport_number = ?";
        return executeQuery($query, [$passport_series, $passport_number]);
    }

    public static function findByIdNumber($id_number) {
        $query = "SELECT * FROM client WHERE id_number = ?";
        return executeQuery($query, [$id_number]);
    }

    public static function store($params) {
        $query = "INSERT INTO client (surname, firstname, patronymic, birth_date, gender, passport_series, passport_number, issued_by, issue_date, id_number, place_of_birth, city_of_residence, residence_address, home_phone, mobile_phone, place_of_work, position_at_work, email, registration_city, marital_status, citizenship, disability, pensioner, monthly_income) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        return executeQuery($query, $params);
    }

    public static function findByNameExcludeId($surname, $firstname, $patronymic, $id) {
        $query = "SELECT * FROM client WHERE surname = ? AND firstname = ? AND patronymic = ? AND id != ?";
        return executeQuery($query, [$surname, $firstname, $patronymic, $id]);
    }

    public static function findByPassportExcludeId($passport_series, $passport_number, $id) {
        $query = "SELECT * FROM client WHERE passport_series = ? AND passport_number = ? AND id != ?";
        return executeQuery($query, [$passport_series, $passport_number, $id]);
    }

    public static function findByIdNumberExcludeId($id_number, $id) {
        $query = "SELECT * FROM client WHERE id_number = ? AND id != ?";
        return executeQuery($query, [$id_number, $id]);
    }

    public static function update($params, $id) {
        $query = "UPDATE client SET surname = ?, firstname = ?, patronymic = ?, birth_date = ?, gender = ?, passport_series = ?, passport_number = ?, issued_by = ?, issue_date = ?, id_number = ?, place_of_birth = ?, city_of_residence = ?, residence_address = ?, home_phone = ?, mobile_phone = ?, place_of_work = ?, position_at_work = ?, email = ?, registration_city = ?, marital_status = ?, citizenship = ?, disability = ?, pensioner = ?, monthly_income = ? WHERE id = ?";
        array_push($params, $id);
        return executeQuery($query, $params);
    }
}