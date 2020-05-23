<?php

// import class
require_once 'DBManager.php';
require_once '../entity/User.php';

class UserDAO {
    // connect to database
    private $man;
    private $dbh;

    public function connect() {
        $this->man = new DBManager();
        $this->dbh = $this->man->getConnection();
    }

    public function close() {
        $this->dbh = null;
    }

    public function userExistsOrNot($userId) {
        try {
            $sql = 'SELECT COUNT(*) FROM user WHERE user_id = ?';
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($userId));
            $count = (int) $stmt->fetchColumn();
            if ($count == 0) {
                return false;
            } else {
                return true;
            }
            $stmt = null;

        } catch (Exception $e) {
            // echo '<br>DB処理でエラーが発生しました';
            header('Location: /500');
            exit;
        }
    }

    public function getPassword($userId) {
        try {
            $sql = 'SELECT password FROM user WHERE user_id = ?';
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($userId));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result == false) {
                // echo '<br>DB処理でエラーが発生しました';
                header('Location: /500');
                exit;
            } else {
                return $result['password'];
            }
            $stmt = null;

        } catch (Exception $e) {
            // echo '<br>DB処理でエラーが発生しました';
            header('Location: /500');
            exit;
        }
    }

    public function getUser($userId) {
        try {
            $sql = 'SELECT * FROM user WHERE user_id = ?';
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($userId));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $user = new User();
            $isProtected = ($result['is_protected'] == 0)? false: true;
            $deleteFlag = ($result['delete_flag'] == 0)? false: true;

            $user->setUserId($result['user_id']);
            $user->setUserName($result['user_name']);
            $user->setPassword($result['password']);
            $user->setProfile($result['profile']);
            $user->setIconPath($result['icon_path']);
            $user->setCreatedAt($result['created_at']);
            $user->setIsProtected($isProtected);
            $user->setDeleteFlag($deleteFlag);
        } catch (Exception $e) {
            // echo '<br>DB処理でエラーが発生しました';
            header('Location: /500');
            exit;
        }
        return $user;
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
                // echo '<br>データが追加されました';
                $res = true;
            } else {
                // echo '<br>データの追加に失敗しました';
                $res = false;
            }

        } catch (Exception $e) {
            // echo '<br>DB処理でエラーが発生しました';
            header('Location: /500');
            exit;
        }
        return $res;
    }

    public function updateUserWelcome($userId, $userName, $profile, $isProtected) {
        $res = false;
        try {
            $sql = 'UPDATE user SET user_name=?, profile=?, is_protected=? WHERE user_id=?';
            $stmt = $this->dbh->prepare($sql);
            $flag = $stmt->execute(array($userName, $profile, $isProtected, $userId));

            if ($flag) {
                // echo '<br>データが更新されました';
                $res = true;
            } else {
                // echo '<br>データの更新に失敗しました';
                $res = false;
            }

        } catch (Exception $e) {
            // echo '<br>DB処理でエラーが発生しました';
            header('Location: /500');
            exit;
        }
        return $res;
    }


}

?>