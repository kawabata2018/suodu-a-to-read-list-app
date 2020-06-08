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

    public function getAllReadingOrderByTargetDate($searchId) {
        try {
            $this->connect();
            $sql = 'SELECT toread_id, book_name, author_name, memo, color_tag, total_page, current_page, target_date FROM toread
                    WHERE user_id = ? AND is_completed = false AND delete_flag = false
                    ORDER BY target_date';
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($searchId));
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $toReadArray = array();
            foreach ($result as $record) {
                $toRead = new ToRead();
                $toRead->setToreadId($record['toread_id']);
                $toRead->setBookName($record['book_name']);
                $toRead->setAuthorName($record['author_name']);
                $toRead->setMemo($record['memo']);
                $toRead->setColorTag($record['color_tag']);
                $toRead->setTotalPage($record['total_page']);
                $toRead->setCurrentPage($record['current_page']);
                $toRead->setTargetDate($record['target_date']);
                // add to toReadArray
                $toReadArray[] = $toRead;
            }

        } catch (Exception $e) {
            // echo '<br>DB処理でエラーが発生しました';
            header('Location: /500#db');
            exit;
        } finally {
            $this->close();
        }
        return $toReadArray;
    }

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