<?php
require_once 'mysql/db_functions.php';

class Account 
{
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

    public static function getAccountNumber($id) {
        $query = "SELECT number FROM account WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['number'];
    }

    public static function getIdByNumber($number) {
        $query = "SELECT id FROM account WHERE number = ?";
        $result = executeQuery($query, [$number]);
        return $result[0]['id'];
    }

    public static function getBalance($id) {
        $query = "SELECT balance FROM account WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0]['balance'];
    }

    public static function createCurrentAccount($client, $currency, $revocation) {
        $current_account_number = substr(str_shuffle(str_repeat($x='0123456789', ceil(13/strlen($x)) )),1,13);
        $current_account_code = $revocation == 'revocable' ? '3014' : '3414';
        $current_account_activity = "passive";
        $current_account_debit = 0;
        $current_account_credit = 0;
        $current_account_balance = 0;

        self::store($current_account_number, $current_account_code, $current_account_activity, $current_account_debit, $current_account_credit, $current_account_balance, $client, $currency);
        return self::getIdByNumber($current_account_number);
    }

    public static function createInterestAccount($client, $currency, $revocation) {
        $interest_account_number = substr(str_shuffle(str_repeat($x='0123456789', ceil(13/strlen($x)) )),1,13);
        $interest_account_code = $revocation == 'revocable' ? '3071' : '3471';
        $interest_account_activity = "passive";
        $interest_account_debit = 0;
        $interest_account_credit = 0;
        $interest_account_balance = 0;

        self::store($interest_account_number, $interest_account_code, $interest_account_activity, $interest_account_debit, $interest_account_credit, $interest_account_balance, $client, $currency);
        return self::getIdByNumber($interest_account_number);
    }

    public static function deposit($id, $amount) {
        $account = self::find($id);
        $account['balance'] = bcadd($account['balance'], $amount, 8);
        if ($account['activity'] == 'active') {
            $account['debit'] = bcadd($account['debit'], $amount, 8);
        } else {
            $account['credit'] = bcadd($account['credit'], $amount, 8);
        }
        return self::updateAccount($id, $account);
    }

    public static function withdraw($id, $amount) {
        $account = self::find($id);
        $account['balance'] = bcsub($account['balance'], $amount, 8);
        if ($account['activity'] == 'active') {
            $account['credit'] = bcadd($account['credit'], $amount, 8);
        } else {
            $account['debit'] = bcadd($account['debit'], $amount, 8);
        }
        return self::updateAccount($id, $account);
    }

    private static function find($id) {
        $query = "SELECT * FROM account WHERE id = ?";
        $result = executeQuery($query, [$id]);
        return $result[0];
    }

    private static function updateAccount($id, $account) {
        $query = "UPDATE account SET number = ?, code = ?, activity = ?, debit = ?, credit = ?, balance = ?, client = ?, currency = ? WHERE id = ?";
        return executeQuery($query, [$account['number'], $account['code'], $account['activity'], $account['debit'], $account['credit'], $account['balance'], $account['client'], $account['currency'], $id]);
    }
}
