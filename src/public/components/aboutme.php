<div class="container">
    <p class="text-center h4 mt-3"> <?php echo $user->getUserName(); ?>さんの書庫 </p>
    <p class="text-center mt-2"> <?php echo $user->getProfile(); ?> </p>

    <div class="icon text-center">
        <img class="m-0" src="/public/img/yomimushi.png" alt="よみむし" />
    </div>

    <p class="text-center mt-0">created at <?php echo $user->getCreatedAt(); ?> </p>

    <div class="text-right">
        <button type="submit" class="btn btn-info" onClick="location.href=' <?php echo '/public/edit-aboutme?id='.$userId; ?> '">編集</button>
    </div>
</div>
