<?php

require_once '../../entity/ToRead.php';

// get session values
session_start();
$toreadSearchResult = $_SESSION['toread_search_result'];

$record = $toreadSearchResult[$_POST['index']];

?>

<div class="h5 font-yumin text-center mb-4">詳細</div>
<table class="table table-bordered table-striped custom-table box-shadow-2 mb-4">
    <tbody>
    <tr>
        <th class="font-yumin">書名</th>
        <td><?= $record->getBookName(); ?></td>
    </tr>
    <tr>
        <th class="font-yumin">作者名</th>
        <td><?= $record->getAuthorName(); ?></td>
    </tr>
    <tr>
        <th class="font-yumin">進捗度</th>
        <td><?= $record->getCurrentPage() . " / " . $record->getTotalPage(); ?></td>
    </tr>
    <tr>
        <th class="font-yumin">目標</th>
        <td><?= $record->getTargetDate(); ?> まで</td>
    </tr>
    <tr>
        <th class="font-yumin">メモ</th>
        <td><?= nl2br($record->getMemo()); ?></td>
    </tr>
    </tbody>
</table>
<form method="POST" action="/public/edit-toread?toreadId=<?= $record->getToreadId(); ?>">
    <button type="submit" class="btn btn-icon-navy m-2">編集</button>
    <button type="button" class="btn btn-secondary m-2" data-dismiss="modal">閉じる</button>
    <button type="button" class="btn btn-icon-red float-right m-2" onClick="finishReading(<?= $record->getToreadId(); ?>)">読了</button>
</form>