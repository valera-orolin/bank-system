<?php
require 'mysql/db_functions.php';

class MaritalStatus {
    public static function all() {
        $query = "SELECT * FROM marital_status";
        return executeQuery($query);
    }

    public static function destroy($id) {
        $query = "DELETE FROM marital_status WHERE id = ?";
        return executeQuery($query, [$id]);
    }

    public static function store($name) {
        $query = "INSERT INTO marital_status (name) VALUES (?)";
        return executeQuery($query, [$name]);
    }

    public static function update($id, $name) {
        $query = "UPDATE marital_status SET name = ? WHERE id = ?";
        return executeQuery($query, [$name, $id]);
    }
}