<div class="container">
    <p class="text-center h4 mt-3"> <?php echo $user->getUserName(); ?>さんの書庫 </p>
    <p class="text-center mt-2"> <?php echo $user->getProfile(); ?> </p>

    <div class="icon text-center">
        <img class="m-0" src="/public/img/yomimushi.png" alt="よみむし" />
    </div>

    <p class="text-center mt-0">created at <?php echo $user->getCreatedAt(); ?> </p>

    <form method="GET" action="/public/update-aboutme">
        <div class="text-right">
            <button type="submit" class="btn btn-info" >変更</button>
            <input type="hidden" name="id" <?php echo 'value="'.$userId.'"' ?> >
        </div>
    </form>
</div>
