<?php

require_once '../../entity/ToRead.php';

// get session values
session_start();
$toreadSearchResult = $_SESSION['toread_search_result'];

$record = $toreadSearchResult[$_POST['index']];

?>

<div class="h5 font-yumin text-center mb-4">詳細</div>
<form method="POST" action="/public/edit-toread?from=2&toreadId=<?= $record->getToreadId(); ?>">
    <button type="submit" class="btn btn-icon-navy m-2">編集</button>
    <button type="button" class="btn btn-icon-red float-right m-2" onClick="backtoReading(<?= $record->getToreadId(); ?>)">未読</button>
</form>