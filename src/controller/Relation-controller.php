<?php

require_once '../dao/UserDAO.php';
require_once '../dao/RelationDAO.php';

// get query parameters
$action = $_GET['action'];
$searchId = $_GET['id'];

// get session values
session_start();
$userId = $_SESSION['user_id'];

// definite sort types
$actionTypes = array(
    'search',       // search
    'follow',       // follow
    'accept',       // accept
    'unfollow'      // unfollow
);

// check action
if (! in_array($action, $actionTypes)) {
    header('Location: /404#invalidActionType');
    exit;
}

$userDao = new UserDAO();
$relationDao = new RelationDAO();
$isExists = $userDao->userExistsOrNot($searchId);
$isPublic = $userDao->userPublicOrNot($searchId);

switch ($action) {
    case 'search':
        if ($isExists) {
            $_SESSION['search_result'] = 'Found';
        } else {
            $_SESSION['search_result'] = 'NotFound';
        }
        header('Location: /public/friends');
        exit;
        break;
    case 'follow':
        // check if userId already follows searchId
        $isFollowing = $relationDao->followingOrNot($userId, $searchId);
        if (! $isFollowing) {
            if ($isPublic) {
                $relationDao->createRelation($userId, $searchId, 0);
            } else {
                $relationDao->createRelation($userId, $searchId, 2);
            }
        }
        header('Location: /controller/Aboutme-controller?id='.$searchId);
        exit;
        break;
    case 'accept':
        // check if userId is followed by searchId
        $isFollowed = $relationDao->followingOrNot($searchId, $userId);
        if ($isFollowed) {
            $relationDao->updateRelation($searchId, $userId, 0);
        }
        header('Location: /controller/Aboutme-controller?id='.$searchId);
        exit;
        break;
    case 'unfollow':
        // check if userId already follows searchId
        $isFollowing = $relationDao->followingOrNot($userId, $searchId);
        if ($isFollowing) {
            $relationDao->deleteRelation($userId, $searchId);
        }
        header('Location: /controller/Aboutme-controller?id='.$searchId);
        exit;
        break;
}

?>