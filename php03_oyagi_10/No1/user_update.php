<?php
//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//   POSTデータ受信 → DB接続 → SQL実行 → 前ページへ戻る
//2. $id = POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更

require_once ('functions.php');

//1. POSTデータ取得
$name = $_POST["name"];
$lid = $_POST["lid"];
$lpw = $_POST["lpw"];
if (isset($_POST['kanri_flg'])){
    $kanri_flg = 1;
    $kanri_flg_str = '管理者';    
} else {
    $kanri_flg = 0;
    $kanri_flg_str = '一般';
}
if (isset($_POST['life_flg'])){
    $life_flg = 1;
    $life_flg_str = '有効';
} else {
    $life_flg = 0;
    $life_flg_str = '無効';
}
$id = $_POST["id"];
$user_pdo = user_db_conn();

//３．データ登録SQL作成
$stmt = $user_pdo->prepare("UPDATE gs_user_table SET name=:name,lid=:lid,lpw=:lpw,kanri_flg=:kanri_flg,life_flg=:life_flg WHERE id=:id;");
$stmt->bindValue(':name', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':kanri_flg', $kanri_flg, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':life_flg', $life_flg, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':id', $id, PDO::PARAM_INT);      //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status == false) {
    sql_error($stmt);
} else {
    $stmt = $user_pdo->prepare("SELECT * FROM gs_user_table WHERE id=".$id);
    $status = $stmt->execute();
    $result = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ユーザー情報編集結果</title>
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
    <form method="POST" action="update.php">
    <div class="jumbotron">
    <fieldset>
        <legend>ユーザー情報編集結果</legend>
        <label>ユーザー名：<?php print ($result["name"]) ?></label><br>
        <label>ログインID：<?= $result["lid"] ?></label><br>
        <label>パスワード：<?= $result["lpw"] ?></label><br>
        <label>管理者/一般：<?= $kanri_flg_str ?></label><br>
        <label>有効/無効：<?= $life_flg_str ?></label><br>
        <input type="hidden" name="id" value=<?= $result["id"] ?>>
        </fieldset>
    </div>
    </form>
    <!-- Main[End] -->

</body>

</html>