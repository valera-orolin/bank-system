<?php
require_once 'mysql/db_functions.php';

class Deposit 
{
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

    public static function getRate($id) {
        $query = "SELECT rate FROM deposit_type WHERE id = (SELECT deposit_type FROM deposit WHERE id = ?)";
        $result = executeQuery($query, [$id]);
        return $result[0]['rate'];
    }

    public static function getCurrency($id) {
        $query = "SELECT currency FROM deposit_type WHERE id = (SELECT deposit_type FROM deposit WHERE id = ?)";
        $result = executeQuery($query, [$id]);
        return $result[0]['currency'];
    }

    public static function getAmount($id) {
        $query = "SELECT amount FROM deposit WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['amount'];
    }

    public static function getDepositType($id) {
        $query = "SELECT deposit_type FROM deposit WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['deposit_type'];
    }
    
    public static function getCurrentAccount($id) {
        $query = "SELECT current_account FROM deposit WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['current_account'];
    }
    
    public static function getInterestAccount($id) {
        $query = "SELECT interest_account FROM deposit WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['interest_account'];
    }    
}
