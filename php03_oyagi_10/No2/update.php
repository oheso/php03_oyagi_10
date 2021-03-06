<?php
require_once ('UserLogic.php');
require_once ('functions.php');
session_start();

// ログインしてるか判定し、していなかったら新規登録画面へ返す
$result = UserLogic::checkLogin();

if (!$result){
    $_SESSION['login_err'] = 'ユーザーを登録してログインしてください';
    header('Location: index.php');
    return;
}

$login_user = $_SESSION['login_user'];


//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//   POSTデータ受信 → DB接続 → SQL実行 → 前ページへ戻る
//2. $id = POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更


//1. POSTデータ取得
$name = $_POST["name"];
$url  = $_POST["url"];
$text = $_POST["text"];
$id   = $_POST["id"];
$pdo  = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare("UPDATE gs_bm_table SET name=:name,url=:url,text=:text,indate=sysdate() WHERE id=:id;");
$stmt->bindValue(':name', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':url', $url, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':text', $text, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':id', $id, PDO::PARAM_INT);      //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status == false) {
    sql_error($stmt);
} else {
    $stmt = $pdo->prepare("SELECT * FROM gs_bm_table WHERE id=".$id);
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
    <title>お薦め書籍登録データ編集結果</title>
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
        <legend>お薦め書籍登録データ編集結果</legend>
        <label>書籍名：<?php print ($result["name"]) ?></label><br>
        <label>URL：<?= $result["url"] ?></label><br>
        <label>オススメ理由：<?= $result["text"] ?></label><br>
        <input type="hidden" name="id" value=<?= $result["id"] ?>>
        </fieldset>
    </div>
    </form>
    <!-- Main[End] -->

</body>

</html>