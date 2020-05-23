<?php

class DBManager {
    // data source name
    private $dsn = 'mysql:host=docker-mylamp_db_1;dbname=lamp_db;charset=utf8mb4';
    // user
    private $user = 'phper';
    // password
    private $password = 'secret';

    public function getConnection(){
        try {
            $dbh = new PDO($this->dsn, $this->user, $this->password);
        } catch (PDOException $e) {
            // echo '<br>DBに接続できません';
            header('Location: /500dbconnection');
            exit;
        }
        return $dbh;
    }
}

?>