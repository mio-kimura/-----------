<?php
session_start();
require 'db_connect.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    // メール重複チェック
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email=?");
    $stmt->execute([$email]);
    if ($stmt->fetchColumn() > 0) {
        $message = "このメールアドレスは既に登録されています。";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
        $stmt->execute([$name,$email,$password]);
        $message = "登録成功！ログインページからログインしてください。";
    }
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規登録 - おうちでニコット</title>
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
        .register-box {
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
        input[type="text"], input[type="email"], input[type="password"] {
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
            color: green;
        }
        .error {
            color: red;
        }
        p {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="register-box">
        <h2>新規登録</h2>
        <?php if($message != ''): ?>
            <p class="message <?php if(strpos($message,'全て')!==false || strpos($message,'既に')!==false){echo 'error';} ?>">
                <?php echo $message; ?>
            </p>
        <?php endif; ?>
        <form method="post" action="">
            <input type="text" name="name" placeholder="名前" required>
            <input type="email" name="email" placeholder="メールアドレス" required>
            <input type="password" name="password" placeholder="パスワード" required>
            <input type="submit" value="登録">
        </form>
        <p>
            <a href="login.php">ログインページに戻る</a>
        </p>
    </div>
</body>
</html>
