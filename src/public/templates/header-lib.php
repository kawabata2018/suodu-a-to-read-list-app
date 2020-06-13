<!DOCTYPE html>

<head>
    <title>SUODU.WORK</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/public/css/style.css">
	<link rel="stylesheet" href="/public/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body class="bg-book">
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
                    <a href="<?php echo '/controller/Reading-controller?sort=0&id='.$_GET['id'] ?>" class="nav-link">読みたい</a>
                </li>
                <li class="nav-item px-md-2 cursor-pointer ">
                    <a href="<?php echo '/controller/Library-controller?sort=0&id='.$_GET['id'] ?>" class="nav-link">読んだ</a>
                </li>
                <li class="nav-item px-md-2 cursor-pointer ">
                    <a href="<?php echo '/public/aboutme?id='.$_GET['id'] ?>" class="nav-link">じぶん</a>
                </li>
                <li onClick="signOut()" class="nav-item pl-md-5 pr-md-2 cursor-pointer ">
                    <a class="nav-link" >ログアウト</a>
                </li>
            </ul>
        </div>
    </nav>