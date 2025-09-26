<!-- index.php -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>おうちでニコット ログインページ</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        h1 {
            color: #ff7f50;
            margin-bottom: 40px;
            text-align: center;
        }
        .login-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 250px;
        }
        .login-container a {
            text-decoration: none;
            padding: 15px;
            background-color: #ff7f50;
            color: white;
            text-align: center;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .login-container a:hover {
            background-color: #ff5722;
        }
    </style>
</head>
<body>
    <h1>おうちでニコット ログインページ</h1>
    <div class="login-container">
        <a href="register.php">新規登録</a>
        <a href="login.php">ログイン</a>
        <a href="admin_login.php">管理者用</a>
    </div>
</body>
</html>
