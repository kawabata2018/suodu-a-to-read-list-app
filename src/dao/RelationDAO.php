<?php

// import class
require_once 'DBManager.php';
require_once '../entity/User.php';

class RelationDAO {
    // connect to database
    private $dbh;

    public function connect() {
        $this->dbh = DBManager::getConnection();
    }

    public function close() {
        $this->dbh = null;
    }

    public function followingOrNot($userId, $followingId) {
        try {
            $this->connect();
            $sql = 'SELECT COUNT(relation_id) FROM relation WHERE user_id = ? AND following_id = ?';
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($userId, $followingId));
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

    public function availableOrNot($userId, $followingId) {
        try {
            $this->connect();
            $sql = 'SELECT COUNT(relation_id) FROM relation WHERE user_id = ? AND following_id = ? AND status = ?';
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($userId, $followingId, 0));
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

    public function getFollowingStatus($userId, $followingId) {
        try {
            $this->connect();
            $sql = 'SELECT status FROM relation WHERE user_id = ? and following_id = ?';
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($userId, $followingId));
            $status = (int) $stmt->fetch(PDO::FETCH_COLUMN);

        } catch (Exception $e) {
            // echo '<br>DB処理でエラーが発生しました';
            header('Location: /500#db');
            exit;
        } finally {
            $this->close();
        }
        return $status;
    }

    public function getFollowings($userId) {
        try {
            $this->connect();
            $sql = 'SELECT following_id FROM relation WHERE user_id = ? and status = ?';
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($userId, 0));
            $followings = $stmt->fetchAll(PDO::FETCH_COLUMN);

        } catch (Exception $e) {
            // echo '<br>DB処理でエラーが発生しました';
            header('Location: /500#db');
            exit;
        } finally {
            $this->close();
        }
        return $followings;
    }

    public function getFollowers($userId) {
        try {
            $this->connect();
            $sql = 'SELECT user_id FROM relation WHERE following_id = ? and status = ?';
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($userId, 0));
            $followers = $stmt->fetchAll(PDO::FETCH_COLUMN);

        } catch (Exception $e) {
            // echo '<br>DB処理でエラーが発生しました';
            header('Location: /500#db');
            exit;
        } finally {
            $this->close();
        }
        return $followers;
    }

    public function getPendings($userId) {
        try {
            $this->connect();
            $sql = 'SELECT user_id FROM relation WHERE following_id = ? and status = ?';
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($userId, 2));
            $pendings = $stmt->fetchAll(PDO::FETCH_COLUMN);

        } catch (Exception $e) {
            // echo '<br>DB処理でエラーが発生しました';
            header('Location: /500#db');
            exit;
        } finally {
            $this->close();
        }
        return $pendings;
    }

    public function createRelation($userId, $followingId, $status) {
        $res = false;
        try {
            $this->connect();
            $sql = 'INSERT INTO relation(user_id, following_id, status, related_at) VALUES(?,?,?,?)';
            $stmt = $this->dbh->prepare($sql);
            $timestamp = date('Y-m-d H:i:s');
            $flag = $stmt->execute(array($userId, $followingId, $status, $timestamp));

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

    public function updateRelation($userId, $followingId, $status) {
        $res = false;
        try {
            $this->connect();
            $sql = 'UPDATE relation SET status = ? WHERE user_id = ? AND following_id = ?';
            $stmt = $this->dbh->prepare($sql);
            $flag = $stmt->execute(array($status, $userId, $followingId));

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

    public function deleteRelation($userId, $followingId) {
        $res = false;
        try {
            $this->connect();
            $sql = 'DELETE FROM relation WHERE user_id = ? AND following_id = ?';
            $stmt = $this->dbh->prepare($sql);
            $flag = $stmt->execute(array($userId, $followingId));

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

}

?>