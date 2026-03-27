<?php
function mbTrim($pString) {
    return preg_replace('/\A[\p{Cc}\p{Cf}\p{Z}]++|[\p{Cc}\p{Cf}\p{Z}]++\z/u','', $pString);
}

$is_vaild_author_name = true;
$input_author_name = '';
if(isset($_POST['author_name'])){
    $input_author_name = mbTrim(str_replace("\r\n","\n",$_POST['author_name']));
    $_SESSION['input_pre_author_name'] = $_POST['author_name'];
}else{
    $is_vaild_author_name = false;
}

if($is_vaild_author_name && mb_strlen($input_author_name) > 20){
    $is_vaild_author_name = false;
    $_SESSION['error_author_name'] = '名前は20文字以内で入力してください。(現在'.mb_strlen($input_author_name).'文字)';
}

$is_vaild_message = true;
$input_message ='';
if(isset($_POST['message'])){
    $input_message = mbTrim(str_replace("\r\n","\n",$_POST['message']));
    $_SESSION['input_pre_message'] = $_POST['message'];
}else{
    $is_vaild_message = false;
}

if($is_vaild_message && $input_message === ''){
    $is_vaild_message = false;
    $_SESSION['error_message'] = '投稿内容の入力は必須です。';
}

if($is_vaild_message && mb_strlen($input_message) > 1000){
    $is_vaild_message = false;
    $_SESSION['error_message'] = '投稿内容は1000文字以内で入力してください。(現在'.mb_strlen($input_message).'文字)';
}

if($is_vaild_author_name && $is_vaild_message){
    if($input_author_name === ''){
        $input_author_name = '風吹けば名無し';
    }

    $qury = 'INSERT INTO posts (author_name, message) VALUES (:author_name, :message)';
    
    $stmt = $dbh->prepare($qury);
    
    $stmt -> bindValue(':author_name', $input_author_name, PDO::PARAM_STR);
    $stmt -> bindValue(':message', $input_message, PDO::PARAM_STR);
    
    $stmt -> execute();
    $_SESSION['action-success-text'] = '投稿しました。';
    $_SESSION['action-error-text'] = '';
    $_SESSION['input_pre_author_name'] = '';
    $_SESSION['input_pre_message'] = '';
    $_SESSION['error_author_name'] = '';
    $_SESSION['error_message'] = '';
}else{
    $_SESSION['action-success-text'] = '';
    $_SESSION['action-error-text'] = '入力内容に誤りがあります。';
}

header('Location: /');
exit;