<?php

require_once '../dao/ToReadDAO.php';

// get session values
session_start();
$from = $_SESSION['from'];
$userId = $_SESSION['user_id'];
$toreadId = $_SESSION['toread_id'];
$bookName = $_SESSION['book_name'];
$authorName = $_SESSION['author_name'];
$memo = $_SESSION['memo'];
$currentPage = $_SESSION['current_page'];
$totalPage = $_SESSION['total_page'];
$targetDate = $_SESSION['target_date'];
$colorTag = $_SESSION['color_tag'];

// unset session values
unset($_SESSION['from']);
unset($_SESSION['toread_id']);
unset($_SESSION['book_name']);
unset($_SESSION['author_name']);
unset($_SESSION['memo']);
unset($_SESSION['current_page']);
unset($_SESSION['total_page']);
unset($_SESSION['target_date']);
unset($_SESSION['color_tag']);

if ($currentPage == '') {
    $currentPage = 0;
}

if ($totalPage == '') {
    $totalPage = 10;
}

if ($targetDate == '') {
    $targetDate = '2021-12-31';
}

$dao = new ToReadDAO();

// check whether or not have edit permission
if (! $dao->checkIfAuthorized($toreadId, $userId)) {
    header('Location: /403');
    exit;
}


$res = $dao->updateToRead($toreadId, $bookName, $authorName, $memo, $colorTag, $currentPage, $totalPage, $targetDate);
if ($res) {
    switch ($from) {
        case '1':
            header('Location: /controller/Reading-controller?sort=1&id='.$userId);
            exit;
        case '2':
            header('Location: /controller/Library-controller?sort=1&id='.$userId);
            exit;
    }
    
} else {
    // echo '<br>本の更新に失敗しました。';
    header('Location: /500');
    exit;
}

?>
