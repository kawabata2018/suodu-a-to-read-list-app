<?php

// import class
require_once 'templates/escape-func.php';
require_once '../dao/UserDAO.php';
require_once '../entity/User.php';

$profile = '';
$errors = array('name'=>'', 'profile'=>'');

// get session values
session_start();
$userId = $_SESSION['user_id'];

// confirm whether or not signed in
if ($_GET['id'] == '' or $userId != $_GET['id']) {
    header('Location: /');
    exit;
}

// enable utf-8
mb_regex_encoding("UTF-8");

// get account information
// @user: User object
$dao = new UserDAO();
$dao->connect();
$user = $dao->getUser($userId);
$dao->close();

?>

<?php include('templates/header-lib.php'); ?>

<!-- <nav class="navbar p-2 navbar-light bg-green-login z-depth-0">
    <div class="container">
        <ul class="navbar-nav">
            <button onClick="signOut()" class="btn btn-sm btn-outline-dark navbar-btn navbar-right lign-middle">Sign out</button>
        </ul>
    </div>
</nav> --> 

<nav class="navbar navbar-fixed-top navbar-expand-md navbar-light flex-md-row bg-white border-navbar z-depth-0">

    <a class="navbar-brand" href="/">
        <img src="/public/img/yomimushi.png" width="50" hspace="10" class="d-inline-block active" alt="よみむし"/>
        <span class="align-middle text-brand font-yumin h3" >所読</span>
    </a>
    <button type="button" class="navbar-toggler navbar-right" data-toggle="collapse" data-target="#Mydropdown" aria-controls="Mydropdown" aria-expanded="false" >
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="Mydropdown">
        <ul class="nav navbar-nav flex-row-md ml-auto">
            <li class="nav-item px-md-2 cursor-pointer ">
                <a href="#reading" class="nav-link" data-toggle="tab" aria-controls="reading">読みたい</a>
            </li>
            <li class="nav-item px-md-2 cursor-pointer ">
                <a href="#read" class="nav-link" data-toggle="tab" aria-controls="read">読んだ</a>
            </li>
            <li class="nav-item px-md-2 cursor-pointer ">
                <a href="#aboutme" class="nav-link active" data-toggle="tab" aria-controls="aboutme">じぶん</a>
            </li>
            <li onClick="signOut()" class="nav-item pl-md-5 pr-md-2 cursor-pointer ">
                <a class="nav-link" >ログアウト</a>
            </li>
        </ul>
    </div>
</nav>

<div class="tab-content">
    <div id="reading" class="tab-pane fade">
        <?php include('components/reading.php'); ?>
    </div>

    <div id="read" class="tab-pane fade">
        <?php include('components/read.php'); ?>
    </div>

    <div id="aboutme" class="tab-pane fade show active">
        <?php include('components/aboutme.php'); ?>
    </div>
</div>


<!-- <div class="container text-right">
    <button onClick="signOut()" class="btn btn-sm btn-secondary">Sign out</button>
</div> -->

<footer class="section mt-2">
    <div class="text-center text-muted">&copy; Copyright 2020 Kawabata</div>
</footer>

<script>
function signOut() {
    var res = confirm('ログアウトしますか？');
    if (res) {
        location.replace('/controller/Logout-controller');
    }
}
</script>
<?php include('templates/footer.php'); ?>

