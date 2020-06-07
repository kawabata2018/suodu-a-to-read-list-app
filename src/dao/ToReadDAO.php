<?php

// import class
require_once 'DBManager.php';
require_once '../entity/ToRead.php';

class ToReadDAO {
    // connect to database
    private $dbh;

    public function connect() {
        $this->dbh = DBManager::getConnection();
    }

    public function close() {
        $this->dbh = null;
    }

    // public function getPassword($userId) {
    //     try {
    //         $sql = 'SELECT password FROM user WHERE user_id = ?';
    //         $stmt = $this->dbh->prepare($sql);
    //         $stmt->execute(array($userId));
    //         $result = $stmt->fetch(PDO::FETCH_ASSOC);
    //         if ($result == false) {
    //             // echo '<br>DB処理でエラーが発生しました';
    //             header('Location: /500');
    //             exit;
    //         } else {
    //             return $result['password'];
    //         }
    //         $stmt = null;

    //     } catch (Exception $e) {
    //         // echo '<br>DB処理でエラーが発生しました';
    //         header('Location: /500#db');
    //         exit;
    //     }
    // }

    // public function getUser($userId) {
    //     try {
    //         $sql = 'SELECT * FROM user WHERE user_id = ?';
    //         $stmt = $this->dbh->prepare($sql);
    //         $stmt->execute(array($userId));
    //         $result = $stmt->fetch(PDO::FETCH_ASSOC);

    //         $user = new User();
    //         $isProtected = ($result['is_protected'] == 0)? false: true;
    //         $deleteFlag = ($result['delete_flag'] == 0)? false: true;

    //         $user->setUserId($result['user_id']);
    //         $user->setUserName($result['user_name']);
    //         $user->setPassword($result['password']);
    //         $user->setProfile($result['profile']);
    //         $user->setIconPath($result['icon_path']);
    //         $user->setCreatedAt($result['created_at']);
    //         $user->setIsProtected($isProtected);
    //         $user->setDeleteFlag($deleteFlag);
    //     } catch (Exception $e) {
    //         // echo '<br>DB処理でエラーが発生しました';
    //         header('Location: /500#db');
    //         exit;
    //     }
    //     return $user;
    // }

    public function createToRead($userId, $bookName, $colorTag, $totalPage, $targetDate) {
        $res = false;
        try {
            $this->connect();
            $sql = 'INSERT INTO toread(user_id, book_name, color_tag, total_page, target_date, created_at) VALUES(?,?,?,?,?,?)';
            $stmt = $this->dbh->prepare($sql);
            $timestamp = date('Y-m-d H:i:s');
            $flag = $stmt->execute(array($userId, $bookName, $colorTag, $totalPage, $targetDate, $timestamp));

            if ($flag) {
                // echo '<br>データが追加されました';
                $res = true;
            } else {
                // echo '<br>データの追加に失敗しました';
                $res = false;
            }

        } catch (Exception $e) {
            // echo '<br>DB処理でエラーが発生しました';
            header('Location: /500#db');
            exit;
        } finally {
            $this->close();
        }
        return $res;
    }

    // public function updateUserWelcome($userId, $userName, $profile, $isProtected) {
    //     $res = false;
    //     try {
    //         $sql = 'UPDATE user SET user_name=?, profile=?, `is_protected`=? WHERE user_id=?';
    //         $stmt = $this->dbh->prepare($sql);
    //         $stmt->bindParam(1, $userName);
    //         $stmt->bindParam(2, $profile);
    //         $stmt->bindParam(3, $isProtected, PDO::PARAM_BOOL);
    //         $stmt->bindParam(4, $userId);
    //         $flag = $stmt->execute();

    //         if ($flag) {
    //             // echo '<br>データが更新されました';
    //             $res = true;
    //         } else {
    //             // echo '<br>データの更新に失敗しました';
    //             $res = false;
    //         }

    //     } catch (Exception $e) {
    //         // echo '<br>DB処理でエラーが発生しました';
    //         header('Location: /500#db');
    //         exit;
    //     }
    //     return $res;
    // }


}

?>