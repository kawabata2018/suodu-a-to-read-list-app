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

    public function getToReadByToReadId($toreadId) {
        try {
            $this->connect();
            $sql = 'SELECT * FROM toread WHERE toread_id = ?';
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($toreadId));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $toread = new ToRead();
            $toread->setToreadId($result['toread_id']);
            $toread->setUserId($result['user_id']);
            $toread->setIsCompleted($result['is_completed']);
            $toread->setBookName($result['book_name']);
            $toread->setAuthorName($result['author_name']);
            $toread->setMemo($result['memo']);
            $toread->setColorTag($result['color_tag']);
            $toread->setTotalPage($result['total_page']);
            $toread->setCurrentPage($result['current_page']);
            $toread->setCompletedOn($result['completed_on']);
            $toread->setTargetDate($result['target_date']);
            $toread->setCreatedAt($result['created_at']);
            $toread->setUpdatedAt($result['updated_at']);
            $toread->setDeleteFlag($result['delete_flag']);

        } catch (Exception $e) {
            // echo '<br>DB処理でエラーが発生しました';
            header('Location: /500#db');
            exit;
        } finally {
            $this->close();
        }
        return $toread;
    }

    public function checkIfAuthorized($toreadId, $userId) {
        try {
            $this->connect();
            $sql = 'SELECT COUNT(toread_id) FROM toread WHERE toread_id = ? AND user_id = ?';
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($toreadId, $userId));
            $count = (int) $stmt->fetchColumn();
            if ($count == 0) {
                return false;
            } else {
                return true;
            }
            $stmt = null;

        } catch (Exception $e) {
            // echo '<br>DB処理でエラーが発生しました';
            header('Location: /500#db');
            exit;
        } finally {
            $this->close();
        }
    }

    public function createToRead($userId, $bookName, $colorTag, $totalPage, $targetDate) {
        $res = false;
        try {
            $this->connect();
            $sql = 'INSERT INTO toread(user_id, book_name, color_tag, total_page, target_date, created_at, updated_at) VALUES(?,?,?,?,?,?,?)';
            $stmt = $this->dbh->prepare($sql);
            $timestamp = date('Y-m-d H:i:s');
            $flag = $stmt->execute(array($userId, $bookName, $colorTag, $totalPage, $targetDate, $timestamp, $timestamp));

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

    public function updateProgress($toreadId, $newCurrentPage) {
        $res = false;
        try {
            $this->connect();
            $sql = 'UPDATE toread SET current_page=?, updated_at=? WHERE toread_id=?';
            $stmt = $this->dbh->prepare($sql);
            $timestamp = date('Y-m-d H:i:s');
            $flag = $stmt->execute(array($newCurrentPage, $timestamp, $toreadId));

            if ($flag) {
                // echo '<br>データが更新されました';
                $res = true;
            } else {
                // echo '<br>データの更新に失敗しました';
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

    public function updateToCompleted($toreadId) {
        $res = false;
        try {
            $this->connect();
            $sql = 'UPDATE toread SET is_completed = true, completed_on = ?, updated_at = ? WHERE toread_id = ?';
            $stmt = $this->dbh->prepare($sql);
            $datestamp = date('Y-m-d');
            $timestamp = date('Y-m-d H:i:s');
            $flag = $stmt->execute(array($datestamp, $timestamp, $toreadId));

            if ($flag) {
                // echo '<br>データが更新されました';
                $res = true;
            } else {
                // echo '<br>データの更新に失敗しました';
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

    public function getAllReadingOrderByTargetDate($searchId) {
        try {
            $this->connect();
            $sql = 'SELECT toread_id, book_name, author_name, memo, color_tag, total_page, current_page, target_date FROM toread
                    WHERE user_id = ? AND is_completed = false AND delete_flag = false
                    ORDER BY target_date';
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($searchId));
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $toreadArray = array();
            foreach ($result as $record) {
                $toread = new ToRead();
                $toread->setToreadId($record['toread_id']);
                $toread->setBookName($record['book_name']);
                $toread->setAuthorName($record['author_name']);
                $toread->setMemo($record['memo']);
                $toread->setColorTag($record['color_tag']);
                $toread->setTotalPage($record['total_page']);
                $toread->setCurrentPage($record['current_page']);
                $toread->setTargetDate($record['target_date']);
                // add to toreadArray
                $toreadArray[] = $toread;
            }

        } catch (Exception $e) {
            // echo '<br>DB処理でエラーが発生しました';
            header('Location: /500#db');
            exit;
        } finally {
            $this->close();
        }
        return $toreadArray;
    }

    public function getAllReadingOrderByUpdatedAt($searchId) {
        try {
            $this->connect();
            $sql = 'SELECT toread_id, book_name, author_name, memo, color_tag, total_page, current_page, target_date FROM toread
                    WHERE user_id = ? AND is_completed = false AND delete_flag = false
                    ORDER BY updated_at DESC';
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($searchId));
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $toreadArray = array();
            foreach ($result as $record) {
                $toread = new ToRead();
                $toread->setToreadId($record['toread_id']);
                $toread->setBookName($record['book_name']);
                $toread->setAuthorName($record['author_name']);
                $toread->setMemo($record['memo']);
                $toread->setColorTag($record['color_tag']);
                $toread->setTotalPage($record['total_page']);
                $toread->setCurrentPage($record['current_page']);
                $toread->setTargetDate($record['target_date']);
                // add to toreadArray
                $toreadArray[] = $toread;
            }

        } catch (Exception $e) {
            // echo '<br>DB処理でエラーが発生しました';
            header('Location: /500#db');
            exit;
        } finally {
            $this->close();
        }
        return $toreadArray;
    }

    public function getAllReadingOrderByBookName($searchId) {
        try {
            $this->connect();
            $sql = 'SELECT toread_id, book_name, author_name, memo, color_tag, total_page, current_page, target_date FROM toread
                    WHERE user_id = ? AND is_completed = false AND delete_flag = false
                    ORDER BY book_name';
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($searchId));
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $toreadArray = array();
            foreach ($result as $record) {
                $toread = new ToRead();
                $toread->setToreadId($record['toread_id']);
                $toread->setBookName($record['book_name']);
                $toread->setAuthorName($record['author_name']);
                $toread->setMemo($record['memo']);
                $toread->setColorTag($record['color_tag']);
                $toread->setTotalPage($record['total_page']);
                $toread->setCurrentPage($record['current_page']);
                $toread->setTargetDate($record['target_date']);
                // add to toreadArray
                $toreadArray[] = $toread;
            }

        } catch (Exception $e) {
            // echo '<br>DB処理でエラーが発生しました';
            header('Location: /500#db');
            exit;
        } finally {
            $this->close();
        }
        return $toreadArray;
    }

    public function getAllReadingOrderByColorTag($searchId, $colorTag) {
        try {
            $this->connect();
            $sql = 'SELECT toread_id, book_name, author_name, memo, color_tag, total_page, current_page, target_date FROM toread
                    WHERE user_id = ? AND color_tag = ? AND is_completed = false AND delete_flag = false
                    ORDER BY target_date';
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($searchId, $colorTag));
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $toreadArray = array();
            foreach ($result as $record) {
                $toread = new ToRead();
                $toread->setToreadId($record['toread_id']);
                $toread->setBookName($record['book_name']);
                $toread->setAuthorName($record['author_name']);
                $toread->setMemo($record['memo']);
                $toread->setColorTag($record['color_tag']);
                $toread->setTotalPage($record['total_page']);
                $toread->setCurrentPage($record['current_page']);
                $toread->setTargetDate($record['target_date']);
                // add to toreadArray
                $toreadArray[] = $toread;
            }

        } catch (Exception $e) {
            // echo '<br>DB処理でエラーが発生しました';
            header('Location: /500#db');
            exit;
        } finally {
            $this->close();
        }
        return $toreadArray;
    }

    public function getAllLibraryOrderByCompletedOn($searchId) {
        try {
            $this->connect();
            $sql = 'SELECT toread_id, book_name, author_name, memo, color_tag, total_page, current_page, completed_on FROM toread
                    WHERE user_id = ? AND is_completed = true AND delete_flag = false
                    ORDER BY completed_on';
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($searchId));
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $toreadArray = array();
            foreach ($result as $record) {
                $toread = new ToRead();
                $toread->setToreadId($record['toread_id']);
                $toread->setBookName($record['book_name']);
                $toread->setAuthorName($record['author_name']);
                $toread->setMemo($record['memo']);
                $toread->setColorTag($record['color_tag']);
                $toread->setTotalPage($record['total_page']);
                $toread->setCurrentPage($record['current_page']);
                $toread->setCompletedOn($record['completed_on']);
                // add to toreadArray
                $toreadArray[] = $toread;
            }

        } catch (Exception $e) {
            // echo '<br>DB処理でエラーが発生しました';
            header('Location: /500#db');
            exit;
        } finally {
            $this->close();
        }
        return $toreadArray;
    }

    public function getAllLibraryOrderByUpdatedAt($searchId) {
        try {
            $this->connect();
            $sql = 'SELECT toread_id, book_name, author_name, memo, color_tag, total_page, current_page, completed_on FROM toread
                    WHERE user_id = ? AND is_completed = true AND delete_flag = false
                    ORDER BY updated_at DESC';
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($searchId));
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $toreadArray = array();
            foreach ($result as $record) {
                $toread = new ToRead();
                $toread->setToreadId($record['toread_id']);
                $toread->setBookName($record['book_name']);
                $toread->setAuthorName($record['author_name']);
                $toread->setMemo($record['memo']);
                $toread->setColorTag($record['color_tag']);
                $toread->setTotalPage($record['total_page']);
                $toread->setCurrentPage($record['current_page']);
                $toread->setCompletedOn($record['completed_on']);
                // add to toreadArray
                $toreadArray[] = $toread;
            }

        } catch (Exception $e) {
            // echo '<br>DB処理でエラーが発生しました';
            header('Location: /500#db');
            exit;
        } finally {
            $this->close();
        }
        return $toreadArray;
    }

    public function getAllLibraryOrderByBookName($searchId) {
        try {
            $this->connect();
            $sql = 'SELECT toread_id, book_name, author_name, memo, color_tag, total_page, current_page, completed_on FROM toread
                    WHERE user_id = ? AND is_completed = true AND delete_flag = false
                    ORDER BY book_name';
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($searchId));
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $toreadArray = array();
            foreach ($result as $record) {
                $toread = new ToRead();
                $toread->setToreadId($record['toread_id']);
                $toread->setBookName($record['book_name']);
                $toread->setAuthorName($record['author_name']);
                $toread->setMemo($record['memo']);
                $toread->setColorTag($record['color_tag']);
                $toread->setTotalPage($record['total_page']);
                $toread->setCurrentPage($record['current_page']);
                $toread->setCompletedOn($record['completed_on']);
                // add to toreadArray
                $toreadArray[] = $toread;
            }

        } catch (Exception $e) {
            // echo '<br>DB処理でエラーが発生しました';
            header('Location: /500#db');
            exit;
        } finally {
            $this->close();
        }
        return $toreadArray;
    }

    public function getAllLibraryOrderByColorTag($searchId, $colorTag) {
        try {
            $this->connect();
            $sql = 'SELECT toread_id, book_name, author_name, memo, color_tag, total_page, current_page, completed_on FROM toread
                    WHERE user_id = ? AND color_tag = ? AND is_completed = true AND delete_flag = false
                    ORDER BY completed_on';
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($searchId, $colorTag));
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $toreadArray = array();
            foreach ($result as $record) {
                $toread = new ToRead();
                $toread->setToreadId($record['toread_id']);
                $toread->setBookName($record['book_name']);
                $toread->setAuthorName($record['author_name']);
                $toread->setMemo($record['memo']);
                $toread->setColorTag($record['color_tag']);
                $toread->setTotalPage($record['total_page']);
                $toread->setCurrentPage($record['current_page']);
                $toread->setCompletedOn($record['completed_on']);
                // add to toreadArray
                $toreadArray[] = $toread;
            }

        } catch (Exception $e) {
            // echo '<br>DB処理でエラーが発生しました';
            header('Location: /500#db');
            exit;
        } finally {
            $this->close();
        }
        return $toreadArray;
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