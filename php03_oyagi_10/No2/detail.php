<?php
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

//１．PHP
//select.phpのPHPコードをマルっとコピーしてきます。
//※SQLとデータ取得の箇所を修正します。
$id = $_GET['id'];
// var_dump($id);

//【重要】
//insert.phpを修正（関数化）してからselect.phpを開く！！
require_once("functions.php");
$pdo = db_conn();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table WHERE id=".$id);
$status = $stmt->execute();

//３．データ表示
$view = "";
if ($status == false) {
    sql_error($status);
} else {
    $result = $stmt->fetch();
}
?>

<!--
２．HTML
以下にindex.phpのHTMLをまるっと貼り付ける！
理由：入力項目は「登録/更新」はほぼ同じになるからです。
※form要素 input type="hidden" name="id" を１項目追加（非表示項目）
※form要素 action="update.php"に変更
※input要素 value="ここに変数埋め込み"
-->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>お薦め書籍登録データ編集</title>
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

    <!-- Main[Start] -->
    <form method="POST" action="update.php">
    <div class="jumbotron">
    <fieldset>
        <legend>お薦め書籍登録データ編集</legend>
        <label>書籍名：<input type="text" name="name" value=<?= $result["name"] ?>></label><br>
        <label>URL：<input type="url" name="url" value=<?= $result["url"] ?>></label><br>
        <label>オススメ理由：<textArea name="text" rows="4" cols="40"><?= $result["text"] ?></textArea></label><br>
        <input type="hidden" name="id" value=<?= $result["id"] ?>>
        <input type="submit" value="編集完了">
        </fieldset>
    </div>
    </form>
    <!-- Main[End] -->

</body>

</html>