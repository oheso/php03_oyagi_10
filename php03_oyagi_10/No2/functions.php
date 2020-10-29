<?php
/**
 * XSS対策：エスケープ処理
 * @param string $str 対象の文字列
 * @return string 処理された文字列
 */

 function h($str){
     return htmlspecialchars($str, ENT_QUOTES, 'utf-8');
 }

/**
 * CSRF対策
 * @param void
 * @return string $csrf_token
 */

 function setToken(){
     // トークンを生成
     // フォームからそのトークンを送信
     // 送信後の画面でそのトークンを照会
     // トークンを削除
    $csrf_token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $csrf_token;

    return $csrf_token;
 }

//DB接続関数：db_conn()
function db_conn(){
    try {
        $db_name = "gs_bm";    //データベース名
        $db_id   = "root";      //アカウント名
        $db_pw   = "root";      //パスワード：XAMPPはパスワード無しに修正してください。
        $db_host = "localhost"; //DBホスト
        $pdo = new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host, $db_id, $db_pw);
        return $pdo;
    } catch (PDOException $e) {
        exit('DB Connection Error:'.$e->getMessage());
    }
}

//SQLエラー関数：sql_error($stmt)
function sql_error($stmt){
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}

//リダイレクト関数: redirect($file_name)
function redirect($file_name){
    header("Location:".$file_name);
    exit();
}

?>