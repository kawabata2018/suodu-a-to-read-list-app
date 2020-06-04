<?php

class DBManager {
    // data source name
    const DSN = 'mysql:host=docker-mylamp_db_1;dbname=lamp_db;charset=utf8mb4';
    // user
    const USER = 'phper';
    // password
    const PASSWORD = 'secret';

    public static function getConnection(){
        try {
            $dbh = new PDO(self::DSN, self::USER, self::PASSWORD);
        } catch (PDOException $e) {
            // echo '<br>DBに接続できません';
            header('Location: /500#dbconnection');
            exit;
        }
        return $dbh;
    }
}

?>