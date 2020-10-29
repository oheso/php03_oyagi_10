<?php
//１．PHP
//select.phpのPHPコードをマルっとコピーしてきます。
//※SQLとデータ取得の箇所を修正します。
$id = $_GET['id'];
// var_dump($id);

//【重要】
//insert.phpを修正（関数化）してからselect.phpを開く！！
require_once("functions.php");
$user_pdo = user_db_conn();

//２．データ登録SQL作成
$stmt = $user_pdo->prepare("SELECT * FROM gs_user_table WHERE id=".$id);
$status = $stmt->execute();

//３．データ表示
$view = "";
if ($status == false) {
    sql_error($status);
} else {
    $result = $stmt->fetch();
}

if (($result["kanri_flg"]) == 1){
    $kanri_flg = 'true';
}
if (($result["life_flg"]) == 1){
    $life_flg = 'true';
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
    <title>ユーザー情報編集</title>
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
                    <a class="navbar-brand" href="user_mgr.php">ユーザー管理へ戻る</a>
                </div>
            </div>
        </nav>
    </header>
    <!-- Head[End] -->

    <!-- Main[Start] -->
    <form method="POST" action="user_update.php">
    <div class="jumbotron">
    <fieldset>
        <legend>ユーザー情報編集</legend>
        <label>ユーザー名：<input type="text" name="name" value=<?= $result["name"] ?>></label><br>
        <label>ログインID：<input type="text" name="lid" value=<?= $result["lid"] ?>></label><br>
        <label>パスワード：<input type="text" name="lpw" value=<?= $result["lpw"] ?>></label><br>
        <label>管理者設定：<input type="checkbox" name="kanri_flg" <?= $kanri_flg ? 'checked' : '' ?>></label><br>
        <label>アカウント有効：<input type="checkbox" name="life_flg" <?= $life_flg ? 'checked' : '' ?>></label><br>
        <input type="hidden" name="id" value=<?= $result["id"] ?>>
        <input type="submit" value="編集完了">
        </fieldset>
    </div>
    </form>
    <!-- Main[End] -->

</body>

</html>