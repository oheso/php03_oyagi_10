<!-- 次回はユーザーアップデート画面から。ユーザーディテールからの遷移でエラー -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン画面</title>
</head>
<body>
    <h2>ログインフォーム</h2>
    <form action="login.php" method="POST">
        <p>
            <label for="lid">ログインID：</label>
            <input type="text" name="lid">
        </p>
        <p>
            <label for="lpw">パスワード：</label>
            <input type="password" name="lpw">
        </p>
        <p>
            <input type="submit" value="ログイン">
        </p>
    </form>
    <a href="signup_form.php">新規登録はこちら</a><br>
    <a href="user_mgr.php">ユーザー管理画面</a>
</body>
</html>