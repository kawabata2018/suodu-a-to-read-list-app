<?php

require_once '../dao/ToReadDAO.php';

// get session values
session_start();
$userId = $_SESSION['user_id'];

// get user id
$toreadId = $_POST['toreadId'];
$newCurrentPage = $_POST['rangeValue'];

$dao = new ToReadDAO();
$res = $dao->updateProgress($toreadId, $newCurrentPage);

if ($res) {
    // echo '<br>アカウントが更新されました。';
    header('Location: /controller/Reading-controller?sort=1&id='.$userId);
    exit;

} else {
    // echo '<br>アカウント更新に失敗しました。';
    header('Location: /500');
    exit;
}

?>