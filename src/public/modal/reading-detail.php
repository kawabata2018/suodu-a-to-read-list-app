<?php

require_once '../../entity/ToRead.php';

// get session values
session_start();
$toreadSearchResult = $_SESSION['toread_search_result'];

$record = $toreadSearchResult[$_POST['index']];

?>

<div class="h5 font-yumin text-center mb-4">詳細</div>
<table class="table table-bordered table-striped custom-table mb-4">
    <tbody>
    <tr>
        <th class="font-yumin">書名</th>
        <td><?php echo $record->getBookName(); ?></td>
    </tr>
    <tr>
        <th class="font-yumin">作者名</th>
        <td><?php echo $record->getAuthorName(); ?></td>
    </tr>
    <tr>
        <th class="font-yumin">進捗度</th>
        <td><?php echo $record->getCurrentPage() . " / " . $record->getTotalPage(); ?></td>
    </tr>
    <tr>
        <th class="font-yumin">目標</th>
        <td><?php echo $record->getTargetDate(); ?> まで</td>
    </tr>
    <tr>
        <th class="font-yumin">メモ</th>
        <td><?php echo $record->getMemo(); ?></td>
    </tr>
    </tbody>
</table>
<form method="POST" action="/public/edit-reading">
    <input type="hidden" name="toreadId" value="<?php echo $record->getToreadId(); ?>">
    <button type="submit" class="btn btn-info m-2">編集</button>
    <button type="button" class="btn btn-secondary m-2" data-dismiss="modal">閉じる</button>
</form>