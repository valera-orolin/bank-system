<?php
require_once 'mysql/db_functions.php';

class Account {
    public static function all() {
        $query = "SELECT * FROM account";
        return executeQuery($query);
    }

    public static function destroy($id) {
        $query = "DELETE FROM account WHERE id = ?";
        return executeQuery($query, [$id]);
    }

    public static function store($number, $code, $activity, $debit, $credit, $balance, $client, $currency) {
        $client = empty($client) ? null : $client;
        $query = "INSERT INTO account (number, code, activity, debit, credit, balance, client, currency) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        return executeQuery($query, [$number, $code, $activity, $debit, $credit, $balance, $client, $currency]);
    }

    public static function update($id, $number, $code, $activity, $debit, $credit, $balance, $client, $currency) {
        $client = empty($client) ? null : $client;
        $query = "UPDATE account SET number = ?, code = ?, activity = ?, debit = ?, credit = ?, balance = ?, client = ?, currency = ? WHERE id = ?";
        return executeQuery($query, [$number, $code, $activity, $debit, $credit, $balance, $client, $currency, $id]);
    }

    public static function clear() {
        $query = "DELETE FROM `bank`.`account`";
        return executeQuery($query);
    }

    public static function getClientIdNumber($id) {
        if ($id === null) {
            return null;
        }
        $query = "SELECT id_number FROM client WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['id_number'];
    }

    public static function getCurrencySymbol($id) {
        $query = "SELECT symbol FROM currency WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['symbol'];
    }    
}
