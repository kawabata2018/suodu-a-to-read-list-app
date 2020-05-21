<?php

// import class
require 'DBManager.php';

class UserDAO {
    // connect to database
    private $man;
    private $dbh;

    public function connect() {
        $this->man = new DBManager();
        $this->dbh = $this->man->getConnect();
    }

    public function close() {
        $this->dbh = null;
    }

    public function existsUserOrNot($userId) {
        try {
            $sql = 'SELECT COUNT(*) FROM user WHERE user_id = ?';
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($userId));
            $count = (int) $stmt->fetchColumn();
            if ($count==0) {
                return false;
            } else {
                return true;
            }
            $stmt = null;

        } catch (PDOException $e) {
            echo '<br>DB処理でエラーが発生しました';
            // header('Location: /DBError.php');
            exit;
        }
    }

    public function getUser($userId) {
        $sql = 'SELECT * FROM user WHERE user_id = ?';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($userId));
        $result = $stmt->fetch();

    }

    public function createUser($userId, $password) {
        $res = false;
        try {
            $sql = 'INSERT INTO user(user_id, password, created_at) VALUES(?,?,?)';
            $stmt = $this->dbh->prepare($sql);
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $timestamp = date('Y-m-d H:i:s');
            $flag = $stmt->execute(array($userId, $hash, $timestamp));

            if ($flag) {
                $res = true;
            } else {
                echo '<br>データの追加に失敗しました';
            }

        } catch (PDOException $e) {
            echo '<br>DB処理でエラーが発生しました';
            // header('Location: /DBError.php');
            exit;
        }
        return $res;
    }



}

?>