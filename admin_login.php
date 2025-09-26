<?php
session_start();
require 'db_connect.php';
$message = '';

$admin_id = "admin";
$admin_pw = "pass123";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = trim($_POST['admin_id']);
    $pw = trim($_POST['admin_pw']);

    if ($id === $admin_id && $pw === $admin_pw) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $message = "IDまたはパスワードが間違っています。";
    }
}
?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理者ログイン - おうちでニコット</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-box {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            width: 300px;
        }
        h2 {
            text-align: center;
            color: #ff7f50;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }
        input[type="text"], input[type="password"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            padding: 12px;
            background-color: #ff7f50;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #ff5722;
        }
        .message {
            text-align: center;
            color: red;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>管理者ログイン</h2>
        <?php if($message != ''): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <input type="text" name="admin_id" placeholder="管理者ID" required>
            <input type="password" name="admin_pw" placeholder="パスワード" required>
            <input type="submit" value="ログイン">
        </form>
        <p style="text-align:center; margin-top:10px;">
            <a href="index.php">トップに戻る</a>
        </p>
    </div>
</body>
</html>
