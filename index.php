<?php
$connection = new PDO('mysql:host=localhost; dbname=forum; charset=utf8', 'root', 'root');
$data = $connection->query("SELECT * FROM comments WHERE moderation='ok' ORDER BY date DESC");

if ($_POST['text']) {
    $username = htmlspecialchars($_POST['username']);
    $text = htmlspecialchars($_POST['text']);
    $time = date("Y-m-d H:i:s");
    $safe = $connection->prepare("INSERT INTO comments SET username=:username, date='$time',comment=:text");
    $arr = ['username'=>$username, 'text'=>$text];
    $safe->execute($arr);
    Header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0,
          maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-RU-Compatible" content="ie=edge">
    <title>Форум любителей форумов </title>
</head>
<body>
<style>
    body {
        margin: 50px;
        font-family: Arial;
    }

    input, textarea, button {
        margin: 15px;
        display: block;
        font-size: 30px;
    }
</style>
<h1>Форум любителей форумов</h1>
<form method="post">
    <input type="text" name="username" required placeholder="Ваше имя">
    <textarea type="text" name="text" required placeholder="Ваше сообщение" cols="30" rows="5"></textarea>
    <button>Отправить</button>
</form>
<hr>
<h2>Сообщения уважаемых пользователей</h2>
<h3>Все сообщения проходят модерацию ! </h3>
<?php if ($data) {
    foreach ($data as $comments) {
        ?>
        <div style="...">
            <?php echo $comments['date'] . ' ' . $comments['username'] . ' написал ' . $comments['comment'] ?>
        </div>
    <?php }
} ?>
</body>
</html>