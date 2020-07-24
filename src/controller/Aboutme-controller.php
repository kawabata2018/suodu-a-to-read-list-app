<?php

require_once '../dao/UserDAO.php';

// get query parameters
$searchId = $_GET['id'];

// get session values
session_start();
$userId = $_SESSION['user_id'];

$dao = new UserDAO();

// check searchId
$res = $dao->userPublicOrNot($searchId);
if (! $res) {
    $searchId = $userId;
}

// get user entity by user id
$user = $dao->getUser($searchId);
$_SESSION['user_info'] = $user;
header('Location: /public/aboutme?id='.$searchId);
exit;

?>