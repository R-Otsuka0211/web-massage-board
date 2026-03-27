<?php
if(isset($_POST['id']) && $_POST['id']){
    $stmt = $dbh->prepare('DELETE FROM posts WHERE id = :id');
    $stmt -> bindValue(':id', $_POST['id'], PDO::PARAM_INT);
    $stmt -> execute();
    $_SESSION['action-success-text'] = '削除が完了しました';
    $_SESSION['action-error-text'] = '';
}else{
    $_SESSION['action-success-text'] = '';
    $_SESSION['action-error-text'] = 'idがありません';
}

header('Location:/');
exit();