<?php

require_once '../dao/ToReadDAO.php';

// get session values
session_start();
$userId = $_SESSION['user_id'];

// get user id
$toreadId = $_GET['toreadId'];

$dao = new ToReadDAO();

// check whether or not have edit permission
if (! $dao->checkIfAuthorized($toreadId, $userId)) {
    header('Location: /403');
    exit;
}

$res = $dao->updateToCompleted($toreadId);

if ($res) {
    // echo '<br>アカウントが更新されました。';
    header('Location: /controller/Library-controller?sort=1&id='.$userId);
    exit;

} else {
    // echo '<br>アカウント更新に失敗しました。';
    header('Location: /500');
    exit;
}

?>