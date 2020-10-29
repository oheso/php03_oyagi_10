<?php
require_once 'functions.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録画面</title>
</head>
<body>
    <h2>ユーザー登録フォーム</h2>

    <form action="register.php" method="POST">
        <p>
            <label for="name">ユーザー名：</label>
            <input type="text" name="name">
        </p>
        <p>
            <label for="lid">ログインID：</label>
            <input type="text" name="lid">
        </p>
        <p>
            <label for="lpw">パスワード：</label>
            <input type="password" name="lpw">
        </p>
        <p>
            <label for="kanri_flg">管理者権限：</label>
            <input type="checkbox" name="kanri_flg">
        </p>
        <p>
            <input type="submit" value="新規登録">
        </p>
    </form>
    <a href="index.php">戻る</a>
</body>
</html>