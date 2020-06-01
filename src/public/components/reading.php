<div class="container">
    <p class="text-center font-yumin h4 mt-3"> 読みたい </p>

    <button type="button" class="btn btn-info btn-round-2 rounded-circle p-0" data-toggle="modal" data-target="#add-modal">＋</button>
    <div id="add-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <!-- <div class="modal-backdrop fade in"></div> -->
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="container p-3">
                    <h3 class="font-yumin pb-3 text-center">本を簡単追加</h3>
                    <form method="POST">
                        <div class="form-group pb-1">
                            <label>書名（50字以内）</label>
                            <textarea type="text" name="bookname" class="form-control border-login" rows="2"></textarea>
                            <span class="text-danger"> <?php echo $errors['bookname']; ?> </span>
                        </div>
                        <div class="form-group pb-1">
                            <label>ページ数</label>
                            <input type="text" name="totalpage" class="form-control">
                            <span class="text-danger"> <?php echo $errors['totalpage']; ?> </span>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">追加</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
