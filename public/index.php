<?php
session_start();
require_once (__DIR__ . '/../src/db_connect.php');

if(isset($_POST['action_type']) && $_POST['action_type']){
    if($_POST['action_type'] === 'insert'){
        require_once (__DIR__ . '/../src/insert_message.php');
    }else if($_POST['action_type'] === 'delete'){
        require_once (__DIR__ . '/../src/delete_message.php');
    }
}

require_once (__DIR__ . '/../src/session_values.php');

$stmt = $dbh->query('SELECT * FROM posts ORDER BY created_at DESC');
$message_length = $stmt->rowCount();

function convrtTz($datetime_text){
    $datetime = new DateTime($datetime_text);
    $datetime->setTimezone(new DateTimeZone('Asia/Tokyo'));
    return $datetime->format('Y/m/d H:i:s');
}
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="root" content="nonindex"/>
    <link rel="stylesheet" href="./assets/main.css">
    <title>ひとこと掲示板</title>
</head>

<body>
    <div class="page-cover">
        <p class="page-title">ひとこと掲示板</p>
        <hr class="page-divider"/>

        <?php if($messages['action-success-text'] !== '') { ?>
            <div class="action-success-area"><?php echo $messages['action-success-text']; ?></div>
        <?php } ?>
        <?php if($messages['action-error-text'] !== '') { ?>
            <div class="action-failed-area"><?php echo $messages['action-error-text']; ?></div>
        <?php } ?>

        <div class="form-cover">
            <!-- 投稿内容フォーム -->
            <form action="/" method="post">
                <label class="form-input-title" for="author_name">投稿者ニックネーム</label>
                <input type="text" name="author_name" maxlength="30" placeholder="風吹けば名無し" value="<?php echo htmlspecialchars($messages['input_pre_author_name'], ENT_QUOTES); ?>" class="input-author-name" />
                    <?php if($messages['error_author_name'] !== '') { ?>
                        <div class="form-input-error">
                            <?php echo $messages['error_author_name']; ?>
                        </div>
                    <?php } ?>
                <label class="form-input-title" for="message">投稿内容<small>(必須)</small></label>
                <textarea name="message" class="input-message"><?php echo htmlspecialchars($messages['input_pre_message'], ENT_QUOTES); ?></textarea>
                    <?php if($messages['error_message'] !== '') { ?>
                        <div class="form-input-error">
                            <?php echo $messages['error_message']; ?>
                        </div>
                    <?php } ?>
                <input type="hidden" name="action_type" value="insert" />
                <button type="submit" class="input-submit-button">投稿する</button>
            </form>
        </div>

        <hr class="page-divider"/>

        <div class="maggage-list-cover">
	        <small>
                <?php echo $message_length; ?>件の投稿
            </small>

            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                <?php $lines = explode("\n", $row['message']); ?>
                <div class="message-item">
                    <div class="message-title">
                        <div><?php echo htmlspecialchars($row['author_name'], ENT_QUOTES); ?></div>
                        <small><?php echo convrtTz($row['created_at']); ?></small>
                        <div class="spacer"></div>
                        <form action="/" method="post" style="text-align:right">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
                            <input type="hidden" name="action_type" value="delete" />
                            <button type="submit" class="message-delete-button">削除</button>
                        </form>
                    </div>
                    <?php foreach ($lines as $line) {?>
                        <p class="message-line"><?php echo htmlspecialchars($line, ENT_QUOTES); ?></p>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>