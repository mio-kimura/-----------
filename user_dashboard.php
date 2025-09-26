<?php
session_start();
if (!isset($_SESSION['user_logged_in'])) {
    header("Location: login.php");
    exit();
}

require 'db_connect.php';

$message = '';

// 予約登録処理
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $pdo->prepare("
        INSERT INTO reservations 
        (user_id,reservation_date,reservation_time,course,seat,notes) 
        VALUES (?,?,?,?,?,?)
    ");
    $stmt->execute([
        $_SESSION['user_id'],
        $_POST['reservation_date'],
        $_POST['reservation_time'],
        $_POST['course'],
        $_POST['seat'] ?? '',
        $_POST['notes'] ?? ''
    ]);
    $message = "予約が完了しました！";
}

// 既存予約取得
$stmt = $pdo->prepare("
    SELECT * 
    FROM reservations 
    WHERE user_id=? 
    ORDER BY reservation_date,reservation_time
");
$stmt->execute([$_SESSION['user_id']]);
$reservations = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ユーザーダッシュボード - おうちでニコット</title>
<style>
/* 既存のスタイルはそのまま */
body { font-family: Arial, sans-serif; background-color: #f0f4f8; margin:0; padding:0; }
.container { max-width: 800px; margin: 30px auto; background-color:#fff; padding:30px; border-radius:10px; box-shadow:0 4px 12px rgba(0,0,0,0.2);}
h2 { text-align:center; color:#ff7f50; }
form { display:flex; flex-direction:column; gap:15px; margin-top:20px; }
input, select, textarea { padding:10px; border:1px solid #ccc; border-radius:5px; font-size:14px; }
input[type="submit"] { background-color:#ff7f50; color:white; font-weight:bold; border:none; border-radius:8px; cursor:pointer; transition:0.3s; }
input[type="submit"]:hover { background-color:#ff5722; }
table { width:100%; border-collapse:collapse; margin-top:30px; }
table th, table td { border:1px solid #ccc; padding:10px; text-align:center; }
table th { background-color:#ff7f50; color:white; }
.message { text-align:center; color:green; font-weight:bold; }
.logout { text-align:right; margin-bottom:10px; }
.logout a { text-decoration:none; color:#ff7f50; font-weight:bold; }
</style>
</head>
<body>
<div class="container">
    <div class="logout">
        <a href="logout.php">ログアウト</a>
    </div>

    <h2>ようこそ、<?php echo htmlspecialchars($_SESSION['user_name']); ?> さん</h2>

    <?php if($message != ''): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <label>予約日</label>
        <input type="date" name="reservation_date" required>

        <label>予約時間</label>
        <input type="time" name="reservation_time" required>

        <label>施術内容</label>
        <select name="course" required>
            <option value="ハンド">ハンド</option>
            <option value="フット">フット</option>
            <option value="リンパドレナージュ">リンパドレナージュ</option>
            <option value="フェイシャル">フェイシャル</option>
            <option value="メイク">メイク</option>
            <option value="ネイル">ネイル</option>
        </select>

        
        </select>

        <label>備考</label>
        <textarea name="notes" rows="3" placeholder="任意"></textarea>

        <input type="submit" value="予約する">
    </form>

    <h3>予約一覧</h3>
    <table>
        <tr>
            <th>日付</th>
            <th>時間</th>
            <th>名前</th>
            <th>施術内容</th>
            <th>備考</th>
        </tr>
        <?php if(count($reservations) > 0): ?>
            <?php foreach($reservations as $res): ?>
                <tr>
                    <td><?php echo htmlspecialchars($res['reservation_date']); ?></td>
                    <td><?php echo htmlspecialchars($res['reservation_time']); ?></td>
                    <td><?php echo htmlspecialchars($_SESSION['user_name']); ?></td>
                    <td><?php echo htmlspecialchars($res['course']); ?></td>
                    <td><?php echo htmlspecialchars($res['notes']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">予約はありません</td>
            </tr>
        <?php endif; ?>
    </table>
</div>
</body>
</html>
