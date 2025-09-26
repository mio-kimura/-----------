<?php
session_start();
require 'db_connect.php';
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// 予約一覧取得（全ユーザー分）
$stmt = $pdo->query("SELECT r.id,u.name,r.reservation_date,r.reservation_time,r.course,r.seat,r.notes 
                     FROM reservations r 
                     JOIN users u ON r.user_id = u.id 
                     ORDER BY r.reservation_date,r.reservation_time");
$reservations = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理者ダッシュボード - おうちでニコット</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #ff7f50;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background-color: #ff7f50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .logout {
            display: block;
            width: 120px;
            margin: 0 auto 20px auto;
            text-align: center;
            padding: 10px;
            background-color: #ff7f50;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }
        .logout:hover {
            background-color: #ff5722;
        }
    </style>
</head>
<body>
    <h2>管理者ダッシュボード</h2>
    <a href="admin_login.php" class="logout">ログアウト</a>

    <table>
        <tr>
            <th>日付</th>
            <th>時間</th>
            <th>名前</th>
            <th>施術内容</th>
            <th>備考</th>
        </tr>
        <?php foreach($reservations as $res): ?>
            <tr>
              <td><?php echo htmlspecialchars($res["reservation_date"]); ?></td> 
<td><?php echo htmlspecialchars($res["reservation_time"]); ?></td>
<td><?php echo htmlspecialchars($res["name"]); ?></td>
<td><?php echo htmlspecialchars($res["course"]); ?></td>
<td><?php echo htmlspecialchars($res["notes"]); ?></td>

            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
