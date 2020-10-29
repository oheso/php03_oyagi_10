<?php
require_once ('functions.php');
$user_pdo = user_db_conn();

//２．データ取得SQL作成
$stmt = $user_pdo->prepare("SELECT * FROM gs_user_table");
$status = $stmt->execute();

//３．データ表示
$view="";
if ($status == false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
} else {
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){//←一つずつ取ってくるという定型文
    if (($result['kanri_flg']) == 0){
      $kanri_flg = '一般';
    } else {
      $kanri_flg = '管理者';
    }
    if (($result['life_flg']) == 0){
      $life_flg = '無効';
    } else {
      $life_flg = '有効';
    }
    $view .= '<tr>';
    $view .= '<td>'.$result['name'].'</td>';
    $view .= '<td>'.$result['lid'].'</td>';
    $view .= '<td>'.$result['lpw'].'</td>';
    $view .= '<td>'.$kanri_flg.'</td>';
    $view .= '<td>'.$life_flg.'</td>';
    $view .= '<td><a href="user_detail.php?id='.$result["id"].'">編集</a>';
    $view .= '<br>';
    $view .= '<a href="user_delete.php?id='.$result["id"].'">削除</a></td>';
    $view .= '</tr>';
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ユーザー管理</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">ログイン画面へ</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
  <div>
    <div class="container jumbotron">
      <table border="1">
          <tr>
              <th>ユーザー名</th>
              <th>ユーザーID</th>
              <th>パスワード</th>
              <th>管理者/一般</th>
              <th>有効/無効</th>
              <th>編集<br>削除</th>
          </tr>
          <?= $view ?>
      </table>
    </div>
  </div>
<!-- Main[End] -->

</body>
</html>
