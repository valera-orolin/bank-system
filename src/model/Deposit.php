<?php
require_once 'mysql/db_functions.php';

class Deposit {
    public static function all() {
        $query = "SELECT * FROM deposit";
        return executeQuery($query);
    }

    public static function destroy($id) {
        $query = "DELETE FROM deposit WHERE id = ?";
        return executeQuery($query, [$id]);
    }

    public static function store($deposit_type, $start_date, $client, $current_account, $interest_account, $amount) {
        $query = "INSERT INTO deposit (deposit_type, start_date, client, current_account, interest_account, amount) VALUES (?, ?, ?, ?, ?, ?)";
        return executeQuery($query, [$deposit_type, $start_date, $client, $current_account, $interest_account, $amount]);
    }

    public static function update($id, $deposit_type, $start_date, $client, $current_account, $interest_account, $amount) {
        $query = "UPDATE deposit SET deposit_type = ?, start_date = ?, client = ?, current_account = ?, interest_account = ?, amount = ? WHERE id = ?";
        return executeQuery($query, [$deposit_type, $start_date, $client, $current_account, $interest_account, $amount, $id]);
    }

    public static function clear() {
        $query = "DELETE FROM `bank`.`deposit`";
        return executeQuery($query);
    }
}
