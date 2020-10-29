<?php
require_once('functions.php');
require_once ('UserLogic.php');
session_start();

// ログインしてるか判定し、していなかったら新規登録画面へ返す
$result = UserLogic::checkLogin();

if (!$result){
    $_SESSION['login_err'] = 'ユーザーを登録してログインしてください';
    header('Location: index.php');
    return;
}

$login_user = $_SESSION['login_user'];


$id = $_GET['id'];
$pdo = connect();
$stmt = $pdo->prepare('DELETE FROM users WHERE id=:id');
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status == false) {
    sql_error($stmt);
} else {
    $result = '削除成功';
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ユーザー情報削除</title>
    <link rel="stylesheet" href="css/range.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body id="main">
    <!-- Head[Start] -->
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="select.php">メイン画面へ戻る</a>
                </div>
            </div>
        </nav>
    </header>
    <!-- Head[End] -->
    <h2><?= $result ?></h2>
</body>

</html>