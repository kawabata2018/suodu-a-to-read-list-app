<?php

require_once '../dao/UserDAO.php';
require_once '../dao/RelationDAO.php';

// get query parameters
$searchId = $_GET['id'];

// get session values
session_start();
$userId = $_SESSION['user_id'];

$userDao = new UserDAO();
$relationDao = new RelationDAO();

// check searchId
$res = $userDao->userExistsOrNot($searchId);
if (! $res) {
    $searchId = $userId;
}

// search relation info
$relationInfo = array();
// check if userId follows searchId
$isFollowing = $relationDao->followingOrNot($userId, $searchId);
if (! $isFollowing) {
    array_push($relationInfo, 'NotFollowing');
} else {
    $status = $relationDao->getFollowingStatus($userId, $searchId);
    switch ($status) {
        case 0:
            array_push($relationInfo, 'Following');
            break;
        case 1:
            array_push($relationInfo, 'Blocked');
            break;
        case 2:
            array_push($relationInfo, 'Requesting');
            break;
    }
}
// check if userId is followed by searchId
$isFollowed = $relationDao->followingOrNot($searchId, $userId);
if ($isFollowed) {
    $status = $relationDao->getFollowingStatus($searchId, $userId);
    switch ($status) {
        case 0:
            array_push($relationInfo, 'Followed');
            break;
        case 1:
            array_push($relationInfo, 'Blocking');
            break;
        case 2:
            array_push($relationInfo, 'Pending');
            break;
    }
}

$_SESSION['relation_info'] = $relationInfo;

// get user entity by user id
$user = $userDao->getUser($searchId);
$_SESSION['user_info'] = $user;
header('Location: /public/aboutme?id='.$searchId);
exit;

?>