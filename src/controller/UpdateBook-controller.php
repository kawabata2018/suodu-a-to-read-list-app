<?php

require_once '../dao/ToReadDAO.php';

// get session values
session_start();
$userId = $_SESSION['user_id'];
$toreadId = $_SESSION['toread_id'];
$bookName = $_SESSION['book_name'];
$authorName = $_SESSION['author_name'];
$memo = $_SESSION['memo'];
$totalPage = $_SESSION['total_page'];
$targetDate = $_SESSION['target_date'];
$colorTag = $_SESSION['color_tag'];

// unset session values
unset($_SESSION['toread_id']);
unset($_SESSION['book_name']);
unset($_SESSION['author_name']);
unset($_SESSION['memo']);
unset($_SESSION['total_page']);
unset($_SESSION['target_date']);
unset($_SESSION['color_tag']);

if ($totalPage == '') {
    $totalPage = 10;
}

if ($targetDate == '') {
    $targetDate = '2021-12-31';
}

$dao = new ToReadDAO();

// check whether or not have edit permission
if (! $dao->checkIfAuthorized($toreadId, $userId)) {
    echo $toreadId;
    // header('Location: /403');
    // exit;
}

$res = $dao->updateToRead($toreadId, $bookName, $authorName, $memo, $colorTag, $totalPage, $targetDate);
if ($res) {
    header('Location: /controller/Reading-controller?sort=1&id='.$userId);
    exit;
} else {
    // echo '<br>本の作成に失敗しました。';
    header('Location: /500');
    exit;
}

?>
