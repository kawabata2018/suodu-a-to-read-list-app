<?php

require_once '../dao/UserDAO.php';
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
    '1',    // order by updated_at discent
    '2',    // order by book_name
);

// check sort
if (! in_array($sort, $sortTypes)) {
    header('Location: /404#invalidSortType');
    exit;
}

// check searchId
$userDao = new UserDAO();
$res = $userDao->userExistsOrNot($searchId);
if (! $res) {
    $searchId = $userId;
}

// start searching
$toreadDao = new ToReadDAO();

switch ($sort) {
    case '0':
        $result = $toreadDao->getAllReadingOrderByTargetDate($searchId);
        $_SESSION['toread_search_result'] = $result;
        header('Location: /public/reading?id='.$searchId);
        exit;
        break;
}

?>