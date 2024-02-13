<?php
require_once 'mysql/db_functions.php';

class Currency {
    public static function all() {
        $query = "SELECT * FROM currency";
        return executeQuery($query);
    }

    public static function destroy($id) {
        $query = "DELETE FROM currency WHERE id = ?";
        return executeQuery($query, [$id]);
    }

    public static function store($name, $symbol, $exchange_rate) {
        $query = "INSERT INTO currency (name, symbol, exchange_rate) VALUES (?, ?, ?)";
        return executeQuery($query, [$name, $symbol, $exchange_rate]);
    }

    public static function update($id, $name, $symbol, $exchange_rate) {
        $query = "UPDATE currency SET name = ?, symbol = ?, exchange_rate = ? WHERE id = ?";
        return executeQuery($query, [$name, $symbol, $exchange_rate, $id]);
    }

    public static function clear() {
        $query = "DELETE FROM `bank`.`currency`";
        return executeQuery($query);
    }
}