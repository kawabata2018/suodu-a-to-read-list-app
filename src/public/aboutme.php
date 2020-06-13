<?php

// import class
require_once '../dao/UserDAO.php';
require_once '../entity/User.php';

// enable utf-8
mb_regex_encoding("UTF-8");

// get session values
session_start();
// if session has expired, move to login page
if (!isset($_SESSION['user_id'])) {
    header('Location: /408');
    exit;
}
$userId = $_SESSION['user_id'];

// get account information
// @user: User object
$dao = new UserDAO();
$user = $dao->getUser($userId);

?>

<?php include('templates/header-lib.php'); ?>

<!-- <nav class="navbar p-2 navbar-light bg-icon-green z-depth-0">
    <div class="container">
        <ul class="navbar-nav">
            <button onClick="signOut()" class="btn btn-sm btn-outline-dark navbar-btn navbar-right lign-middle">Sign out</button>
        </ul>
    </div>
</nav> -->

<div class="container">
    <p class="text-center font-yumin h4 mt-3"> <?php echo $user->getUserName(); ?>さんの書庫 </p>
    <p class="text-center mt-2"> <?php echo $user->getProfile(); ?> </p>

    <div class="icon text-center">
        <img class="m-0" src="/public/img/yomimushi.png" alt="よみむし" />
    </div>

    <p class="text-center mt-0">created at <?php echo $user->getCreatedAt(); ?> </p>

    <div class="text-right">
        <button type="submit" class="btn btn-icon-green" onClick="location.href=' <?php echo '/public/edit-aboutme?id='.$userId; ?> '">編集</button>
    </div>
</div>

<!-- <div class="container text-right">
    <button onClick="signOut()" class="btn btn-sm btn-secondary">Sign out</button>
</div> -->

<?php include('templates/footer-lib.php'); ?>
