<?php
require_once ('functions.php');
$user_pdo = user_db_conn();

$name = $_POST['name'];
$lid = $_POST['lid'];
$lpw = $_POST['lpw'];
if (isset($_POST['kanri_flg'])){
    $kanri_flg = 1;
} else {
    $kanri_flg = 0;
}
$stmt = $user_pdo->prepare("INSERT INTO gs_user_table(id,name,lid,lpw,kanri_flg)VALUES(NULL,:name,:lid,:lpw,:kanri_flg)");
$stmt->bindValue(':name', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':kanri_flg', $kanri_flg, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();
if($status==false){
    $error = $stmt->errorInfo();
    exit("エラーメッセージ:".$error[2]);
}else{
    echo '<p>ユーザー登録が完了しました。</p>';
}
// var_dump ($name);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録完了画面</title>
</head>
<body>
    <a href="index.php">ログイン画面へ戻る</a>
</body>
</html>