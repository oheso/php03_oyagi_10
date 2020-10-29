<?php
session_start();
require_once 'UserLogic.php';

if (!$logout = filter_input(INPUT_POST, 'logout')){
    exit('不正なリクエストです');
}

// ログインしてるか判定し、セッションが切れていたらログインしてくださいとメッセージを出す
$result = UserLogic::checkLogin();

if (!$result){
    exit('セッションが切れましたので、ログインし直してください。');
}

// ログアウトする
UserLogic::logout();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログアウト</title>
</head>
<body>
    <h2>ログアウト完了</h2>
    <p>ログアウトしました</p>
    <a href="index.php">ログイン画面へ</a>
</body>
</html>