<?php

require_once '../entity/User.php';
require_once '../dao/UserDAO.php';
require_once '../dao/RelationDAO.php';
require_once '../dao/ToReadDAO.php';

// get query parameters
$sort = $_GET['sort'];
$searchId = $_GET['id'];

// get session values
session_start();
$userId = $_SESSION['user_id'];

// definite sort types
$sortTypes = array(
    '0',    // order by target_date
    '1',    // order by updated_at descent
    '2',    // order by book_name
    '80',   // show only blue
    '81',   // show only red
    '82',   // show only yellow
    '83',   // show only green
);

// check sort
if (! in_array($sort, $sortTypes)) {
    header('Location: /404#invalidSortType');
    exit;
}

// check searchId
$userDao = new UserDAO();
$relationDao = new RelationDAO();
$isAvailable = $relationDao->availableOrNot($userId, $searchId);
if (! $isAvailable) {
    $searchId = $userId;
}

// store its username to session
$_SESSION['user_name'] = $userDao->getName($searchId);

// start searching
$toreadDao = new ToReadDAO();

switch ($sort) {
    case '0':
        $result = $toreadDao->getAllReadingOrderByTargetDate($searchId);
        $_SESSION['toread_search_result'] = $result;
        header('Location: /public/reading?sort=0&id='.$searchId);
        exit;
        break;
    case '1':
        $result = $toreadDao->getAllReadingOrderByUpdatedAt($searchId);
        $_SESSION['toread_search_result'] = $result;
        header('Location: /public/reading?sort=1&id='.$searchId);
        exit;
        break;
    case '2':
        $result = $toreadDao->getAllReadingOrderByBookName($searchId);
        $_SESSION['toread_search_result'] = $result;
        header('Location: /public/reading?sort=2&id='.$searchId);
        exit;
        break;
    case '80':
        $result = $toreadDao->getAllReadingOrderByColorTag($searchId, '0');
        $_SESSION['toread_search_result'] = $result;
        header('Location: /public/reading?sort=80&id='.$searchId);
        exit;
        break;
    case '81':
        $result = $toreadDao->getAllReadingOrderByColorTag($searchId, '1');
        $_SESSION['toread_search_result'] = $result;
        header('Location: /public/reading?sort=81&id='.$searchId);
        exit;
        break;
    case '82':
        $result = $toreadDao->getAllReadingOrderByColorTag($searchId, '2');
        $_SESSION['toread_search_result'] = $result;
        header('Location: /public/reading?sort=82&id='.$searchId);
        exit;
        break;
    case '83':
        $result = $toreadDao->getAllReadingOrderByColorTag($searchId, '3');
        $_SESSION['toread_search_result'] = $result;
        header('Location: /public/reading?sort=83&id='.$searchId);
        exit;
        break;
}

?>