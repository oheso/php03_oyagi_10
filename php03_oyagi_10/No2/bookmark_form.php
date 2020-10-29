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
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>お薦め書籍新規登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">メイン画面へ戻る</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="POST" action="insert.php">
  <div class="jumbotron">
   <fieldset>
    <legend>あなたのお薦め書籍を登録してください♪</legend>
     <label>書籍名：<input type="text" name="name"></label><br>
     <label>URL：<input type="url" name="url"></label><br>
     <label>お薦め理由：<textArea name="text" rows="4" cols="40"></textArea></label><br>
     <input type="submit" value="登録">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>
