<?php
session_start();
if (!$_SESSION['login'] || !$_SESSION['password']) {
    header('Location: login.php');
    die();
}
if ($_POST['unlogin']) {
    session_destroy();
    header('Location: login.php');
}

if (count($_POST) > 0) {
    header('Location: admin.php');
}

$connection = new PDO('mysql:host=localhost; dbname=forum; charset=utf8', 'root', 'root');
$data = $connection->query("SELECT * FROM comments WHERE moderation='new' ORDER BY date DESC");

?>


    <style>
        body {
            margin: 50px;
            font-family: Arial, sans-serif;
        }

        input, textarea, button {
            margin: 15px;
            display: block;
            font-size: 30px;
        }
    </style>

    <h1>Админка злобного админа</h1>
    <form METHOD="post">
        <?php foreach ($data as $comment) { ?>
            <select name="<?= $comment['id'] ?>" id="<?= $comment['id'] ?>">
                <option value="ok">OK</option>
                <option value="rejected">Отклонить</option>
            </select>
            <label for="<?= $comment['id'] ?>">
                <?= $comment['username'] . ' оставил комментарий "' . $comment['comment'] . "\"<br/>" ?>
            </label>
        <?php } ?>
        <button> Модерировать</button>
    </form>
    <hr>
    <form method="post">
        <input type="submit" name="unlogin" value="Выйти из админки">
    </form>

<?php
foreach ($_POST as $num => $checked) {
    if ($checked == 'ok') {
        $connection->query("UPDATE comments SET moderation='ok' WHERE id=$num");
    } else {
        $connection->query("UPDATE comments SET moderation='rejected' WHERE id=$num");
    }
}

?>